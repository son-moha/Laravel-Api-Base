<?php

namespace Modules\Core\Services;

use Illuminate\Support\Collection;
use Modules\Core\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class BaseService
{
    /**
     * @var BaseRepository;
     */
    protected $mainRepository;

    /**
     * Load relationship
     * @var array
     */
    protected $with_load = [];

    /**
     * @var array|Collection
     */
    protected $filter = [];

    /**
     * @var Builder
     */
    protected $builder;

    public const PAGE_LIMIT = 100;

    public function find($id)
    {
        return $this->mainRepository->find($id);
    }

    /**
     * @param $id
     * @param array $options
     *
     * @return BaseRepository|BaseRepository[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findOr404($id, $options = [])
    {
        $entity = $this->mainRepository->find($id);

        if ($entity) {
            foreach ($options as $key => $value) {
                if ($entity->$key != $value) {
                    abort(404);
                }
            }

            return $entity;
        }

        abort(404);
    }

    public function all()
    {
        return $this->mainRepository->all();
    }

    public function prepareInsertOrUpdate($attributes)
    {
        foreach ($attributes as $key => $input) {
            if ($input instanceof UploadedFile) {
                $name = uniqid() . "-" . time() . '.' . $input->getClientOriginalExtension();

                $path = date('Y') . "/" . date('m') . "/" . date('d');

                if (!Storage::putFileAs($path, $input, $name)) {
                    return false;
                }

                $attributes[$key] = $path . "/" . $name;
            }
        }

        return $attributes;
    }

    public function update($id, array $attributes, array $options = [])
    {
        $attributes = $this->prepareInsertOrUpdate($attributes);

        return $this->mainRepository->update($id, $attributes, $options);
    }

    public function create($attributes)
    {
        $attributes = $this->prepareInsertOrUpdate($attributes);

        return $this->mainRepository->create($attributes);
    }

    public function inserts($data)
    {
        $this->mainRepository->inserts($data);
    }

    public function delete($id)
    {
        return $this->mainRepository->delete($id);
    }

    public function paginate($options = [], $limit = self::PAGE_LIMIT)
    {
        $options['limit'] = request('limit') ?? $limit;
        $this->makeSearchBuilder($options);

        return $this->searchFilter();
    }

    public function ajaxSearch($options, $limit)
    {
        $options['limit'] = $limit;
        $fillable         = $this->mainRepository->getFillable();
        $all_request      = $this->filterRequest(app('request'));
        $filter           = collect($all_request['filter']);
        $key              = '';
        $value            = '';
        foreach ($filter as $k => $v) {
            if (in_array($k, $fillable)) {
                $key   = $k;
                $value = $v;
            }
        }

        if ($key) {
            $options['fields'] = [
                'id', $key
            ];
            $this->makeBuilder($options);
            $this->builder->where($key, 'LIKE', "%" . $value . "%");

            $this->cleanFilterBuilder([$key]);
        } else {
            $this->makeBuilder($options);
        }

        return $this->endFilter();
    }

    public function filter($options = [])
    {
        $this->makeBuilder($options);

        return $this->endFilter();
    }

    public function makeBuilder($has_change = []): void
    {
        $this->makeFilter($has_change);

        $this->builder = $this->mainRepository->makeModel()->with($this->with_load);
    }

    public function makeSearchBuilder($has_change = []): void
    {
        $this->makeSearchFilter($has_change);

        $this->builder = $this->mainRepository->makeModel()->with($this->with_load);
    }

    public function makeFilter($has_change = [])
    {
        $this->with_load = $has_change['with_load'] ?? $this->with_load;

        $this->filter = $this->requestParse($has_change);

        return $this->filter;
    }

    public function makeSearchFilter($has_change = [])
    {
        $this->with_load = $has_change['with_load'] ?? $this->with_load;

        $this->filter = $this->requestSearchParse($has_change);

        return $this->filter;
    }

    public function searchFilter()
    {
        if ($this->filter->has('created_to')) {
            $this->builder->whereDate('created_at', '<=', date($this->filter->get('created_to')) . ' 23:59:59.99');
        }

        if ($this->filter->has('created_from')) {
            $this->builder->whereDate('created_at', '>=', date($this->filter->get('created_from')));
        }

        if ($this->filter->has('created_to') && $this->filter->has('created_from')) {
            $this->builder->whereBetween('created_at', [
                date($this->filter->get('created_from')),
                date($this->filter->get('created_to')) . ' 23:59:59.99'
            ]);
        }

        $this->builder = $this->mainRepository->searchBuilder($this->filter, $this->builder);

        return $this->baseFilter();
    }

    public function endFilter()
    {
        $this->builder = $this->mainRepository->whereBuilder($this->filter, $this->builder);

        return $this->baseFilter();
    }

    private function baseFilter()
    {
        $this->builder = $this->mainRepository->orderBuilder($this->filter->get('order_by'), $this->builder);

        if ($this->filter->has('fields')) {
            $this->builder = $this->builder->select($this->filter->get('fields'));
        }

        if ($this->filter->has('all')) {
            return $this->builder->get();
        }

        if ($this->filter->has('get')) {
            $limit = $this->filter->get('get', 0);
            if (is_numeric($limit) && $limit > 0) {
                return $this->builder->limit($limit)->get();
            }
            return $this->builder->get();
        }

        if ($this->filter->has('limit') && $this->filter->get('limit') === false) {
            return $this->builder->get();
        }

        return $this->builder->paginate($this->filter->get('limit'));
    }

    public function cleanFilterBuilder(array $key)
    {
        $this->filter = $this->filter->forget($key);
    }

    public function requestParse($has_change = [])
    {
        $all_request = $this->filterRequest(app('request'));

        $result = collect($all_request['filter']);

        $result = $result->merge(['order_by' => $all_request['order_by'], 'limit' => $all_request['limit']]);

        if (!empty($has_change)) {
            unset($has_change['with_load']);
            $result = $result->merge($has_change);
        }

        return $result;
    }

    public function requestSearchParse($has_change = [])
    {
        $all_request = $this->filterSearchRequest(app('request'));
        $result      = collect($all_request['filter']);

        $result = $result->merge(['order_by' => $all_request['order_by'], 'limit' => $all_request['limit']]);

        if (!empty($has_change)) {
            unset($has_change['with_load']);
            $result = $result->merge($has_change);
        }

        return $result;
    }

    public function filterRequest(Request $request)
    {
        $result['filter']   = [];
        $result['download'] = $request->input('download', false) === 'true';

        // Get and sanitize filters from the URL
        $result['limit'] = $request->get('limit', self::PAGE_LIMIT);
        if ($raw_filters = $request->all()) {
            Arr::forget($raw_filters, ['token', 'order_by', 'fields', 'page', 'limit', 'download', 'with_load']);
            foreach ($raw_filters as $k => $v) {
                if (is_array($v)) {
                    $result['filter'][$k] = array_filter($v, function ($elm) {
                        return filter_var($elm, FILTER_SANITIZE_ADD_SLASHES);
                    });
                } else {
                    $v = trim($v);
                    if (strlen($v) == 0) {
                        continue;
                    }

                    $result['filter'][$k] = filter_var($v, FILTER_SANITIZE_ADD_SLASHES);
                }
            }
        }

        $result['order_by'] = $this->parseSorting($request->input('order_by'));

        $result['fields'] = ['*'];

        if ($request->has('fields')) {
            $fields           = explode(',', $request->get('fields'));
            $result['fields'] = array_filter(array_map('trim', $fields));
        }

        return $result;
    }

    public function filterSearchRequest(Request $request)
    {
        $result['filter']   = [];
        $result['download'] = $request->input('download', false) === 'true';

        $result['limit'] = $request->get('limit', self::PAGE_LIMIT);
        if ($raw_filters = $request->all()) {
            Arr::forget($raw_filters, ['token', 'order_by', 'fields', 'page', 'limit', 'download', 'with_load']);
            foreach ($raw_filters as $k => $v) {
                $result['filter'][$k] = $v;
            }
        }

        $result['order_by'] = $this->parseSorting($request->input('order_by'));

        $result['fields'] = ['*'];

        if ($request->has('fields')) {
            $fields           = explode(',', $request->get('fields'));
            $result['fields'] = array_filter(array_map('trim', $fields));
        }

        return $result;
    }

    public function parseSorting($string)
    {
        $result = [];

        $sort = explode(',', $string);
        $sort = array_map(function ($s) {
            $s = filter_var($s, FILTER_SANITIZE_STRING);
            return trim($s);
        }, $sort);
        foreach ($sort as $expr) {
            if (empty($expr)) {
                continue;
            }
            if ('-' == substr($expr, 0, 1)) {
                $result[substr($expr, 1)] = 'DESC';
            } else {
                $result[$expr] = 'ASC';
            }
        }
        return $result;
    }

    /**
     * Handle dynamic method calls into the service.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->mainRepository->$method(...$parameters);
    }
}

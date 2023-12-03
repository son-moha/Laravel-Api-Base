<?php

namespace Modules\Core\Repositories;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Entities\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var Builder
     */
    protected $model;

    protected $all_columns;

    public function __construct()
    {
        $this->model = $this->makeModel();
    }

    /**
     * @return BaseModel|mixed
     */
    public function makeModel()
    {
        return app($this->model());
    }

    /**
     * @return BaseModel::class
     */
    abstract public function model();

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    /**
     * @param array $attributes
     *
     * @return $this|Model
     */
    public function create(array $attributes)
    {
        $relations = $attributes['relations'] ?? [];
        /* @var $entity Model */
        try {
            $attributes['created_by'] = auth()->user() ? auth()->user()->id : null;
            $entity                   = $this->model->create($attributes);
            foreach ($relations as $relationName => $ids) {
                if ($entity->$relationName() instanceof HasMany) {
                    $entity->$relationName()->sync($ids);
                }

                if ($entity->$relationName() instanceof BelongsToMany) {
                    $entity->$relationName()->sync($ids);
                }
            }
        } catch (\Exception $e) {
            throw $e;
            // create entity without db exception
        }

        return $entity;
    }

    /**
     * @param $attributes
     * @param array $values
     *
     * @return Model|static
     */
    public function createOrUpdate($attributes, $values = [])
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * @param $attributes
     * @param array $values
     *
     * @return Model|static
     */
    public function firstOrNew($attributes, $values = [])
    {
        return $this->model->firstOrNew($attributes, $values);
    }

    /**
     * @param $id
     * @param array $attributes
     * @param array $options
     *
     * @return BaseRepository|bool|\Illuminate\Database\Eloquent\Collection|Model|null|static[]
     */
    public function update($id, array $attributes, array $options = [])
    {
        $entity = $this->find($id);
        if ($entity) {
            $entity->update($attributes, $options);

            $relations = $attributes['relations'] ?? [];
            /* @var $entity Model */
            try {
                foreach ($relations as $relationName => $ids) {
                    if ($entity->$relationName() instanceof HasMany) {
                        $entity->$relationName()->sync($ids);
                    }

                    if ($entity->$relationName() instanceof BelongsToMany) {
                        $entity->$relationName()->sync($ids);
                    }
                }
            } catch (\Exception $e) {
                // create entity without db exception
            }

            return $entity;
        }

        return false;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            try {
                $result->delete();
            } catch (\Exception $e) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * @param $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($limit)
    {
        return $this->model->paginate($limit);
    }

    public function searchBuilder($conditions, Builder $builder)
    {
        if ($conditions instanceof Collection) {
            $conditions = $conditions->filter(function ($value) {
                return !(empty($value) && $value !== '0' && $value !== 0);
            })->all();
        }

        foreach ($conditions as $field => $value) {
            if (!$this->isFillable($field)) {
                continue;
            }
            if (is_array($value)) {
                if (!empty($value['date']['from'])) {
                    $builder = $builder->where($field, '>=', $value['date']['from']);
                }

                if (!empty($value['date']['to'])) {
                    $builder = $builder->where($field, '<=', $value['date']['to']);
                }

                if (!empty($value['time']['from'])) {
                    $builder = $builder->where($field, '>=', $value['time']['from']);
                }

                if (!empty($value['time']['to'])) {
                    $builder = $builder->where($field, '<=', $value['time']['to']);
                }

                if (
                    !empty($value['checkbox'])
                    && is_array($value['checkbox'])
                    && !$this->isMultiDimensional($value['checkbox'])
                ) {
                    $builder = $builder->whereJsonContains($field, $value['checkbox']);
                }
                if (!empty($value) && !$this->isMultiDimensional($value)) {
                    $builder = $builder->whereIn($field, $value);
                }
            }

            if (is_string($value)) {
                $builder = $builder->where($field, 'LIKE', "%" . $value . "%");
            }
        }

        return $builder;
    }

    public function isMultiDimensional($array): bool
    {
        foreach ($array as $element) {
            if (is_array($element)) {
                return true;
            }
        }
        return false;
    }

    public function whereBuilder($conditions, Builder $builder)
    {
        if ($conditions instanceof Collection) {
            $conditions = $conditions->filter(function ($value) {
                return !(empty($value) && $value !== '0' && $value !== 0);
            })->all();
        }

        foreach ($conditions as $field => $value) {
            if (is_array($value) && !empty($value) && count($value) > 2) {
                [$field, $condition, $val] = $value;
                if (!$this->isFillable($field)) {
                    continue;
                }
                $builder = $builder->where($field, $condition, $val);
            } else {
                if (!$this->isFillable($field)) {
                    continue;
                }
                $builder = $builder->where($field, '=', $value);
            }
        }

        return $builder;
    }

    public function orderBuilder($sorts, Builder $builder)
    {
        $fillables = $this->getFillable();

        if (empty($sorts) && in_array('id', $fillables)) {
            $sorts = ['id' => 'DESC'];
        }

        if (isset($sorts) && !empty($sorts)) {
            foreach ($sorts as $k => $v) {
                if (!in_array($k, $fillables)) {
                    continue;
                }
                $builder = $builder->orderBy($k, $v);
            }
        }

        return $builder;
    }

    public function getFillable()
    {
        $fillables  = $this->model->getFillable();
        $primaryKey = $this->model->getKeyName();
        $createdAt  = $this->model->getCreatedAtColumn();
        $updatedAt  = $this->model->getUpdatedAtColumn();
        if (!in_array($primaryKey, $fillables)) {
            array_push($fillables, $primaryKey, $createdAt, $updatedAt);
        }

        $this->all_columns = $fillables;

        return $fillables;
    }

    public function isFillable($key)
    {
        if (!$this->all_columns) {
            $this->getFillable();
        }

        if (!in_array($key, $this->all_columns)) {
            return false;
        }

        return true;
    }

    /**
     * @param array $dataInsert
     * @return bool
     */
    public function inserts(array $dataInsert)
    {
        return $this->model->insert($dataInsert);
    }

    /**
     * @param array $values
     * @param string|null $index
     * @param bool $raw
     * @return bool
     */
    public function bulkUpdate(array $values, $index = null, $raw = false)
    {
        $table = $this->model;
        $final = [];
        $ids   = [];

        if (!count($values)) {
            return false;
        }

        if (!isset($index) || empty($index)) {
            $index = $table->getKeyName();
        }

        foreach ($values as $val) {
            $ids[] = $val[$index];
            foreach (array_keys($val) as $field) {
                if ($field !== $index) {
                    $finalField      = $raw ? $this->mysqlEscape($val[$field]) : '"' .
                        $this->mysqlEscape($val[$field]) . '"';
                    $value           = (is_null($val[$field]) ? 'NULL' : $finalField);
                    $final[$field][] = 'WHEN `' . $index . '` = "' . $val[$index] . '" THEN ' . $value . ' ';
                }
            }
        }

        $cases = '';
        foreach ($final as $k => $v) {
            $cases .= '`' . $k . '` = (CASE ' . implode("\n", $v) . "\n"
                . 'ELSE `' . $k . '` END), ';
        }

        $query = 'UPDATE `' . $table->getTable() . '` SET ' . substr($cases, 0, -2) .
            " WHERE `$index` IN(" . '"' . implode('","', $ids) . '"' . ');';

        return DB::update($query);
    }

    /**
     * @param $fieldValue
     * @return array|string|string[]
     */

    private function mysqlEscape($fieldValue)
    {
        if (is_array($fieldValue)) {
            return array_map(__METHOD__, $fieldValue);
        }

        if (!empty($fieldValue) && is_string($fieldValue)) {
            return str_replace(
                ['\\', "\0", "\n", "\r", "'", '"', "\x1a"],
                ['\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'],
                $fieldValue
            );
        }

        return $fieldValue;
    }
}

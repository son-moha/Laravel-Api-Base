<?php

namespace Modules\Core\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public function find($id);

    /**
     * @param  array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($columns = ['*']);

    /**
     * @param  array $attributes
     *
     * @return $this|Model
     */
    public function create(array $attributes);

    /**
     * @param $attributes
     * @param array $values
     *
     * @return Model|static
     */
    public function createOrUpdate($attributes, $values = []);

    /**
     * @param $attributes
     * @param array $values
     *
     * @return Model|static
     */
    public function firstOrNew($attributes, $values = []);

    /**
     * @param $id
     * @param  array $attributes
     * @param  array $options
     *
     * @return BaseRepository|bool|\Illuminate\Database\Eloquent\Collection|Model|null|static[]
     */
    public function update($id, array $attributes, array $options = []);

    /**
     * @param $id
     *
     * @return bool
     */
    public function delete($id);

    /**
     * @param $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($limit);

    /**
     * @param $conditions
     * @param Builder $builder
     *
     * @return Builder
     */
    public function whereBuilder($conditions, Builder $builder);

    /**
     * @param $sorts
     * @param Builder $builder
     *
     * @return Builder
     */
    public function orderBuilder($sorts, Builder $builder);

    /**
     * @param  array  $dataInsert
     * @return bool
     */
    public function inserts(array $dataInsert);

    /**
     * @param  array  $values
     * @param  string|null  $index
     * @param  bool  $raw
     * @return bool
     */
    public function bulkUpdate(array $values, $index = null, $raw = false);

    /**
     * Get the fillable attributes for the model.
     *
     * @return array
     */
    public function getFillable();

    /**
     * @param $key
     *
     * @return boolean
     */
    public function isFillable($key);
}

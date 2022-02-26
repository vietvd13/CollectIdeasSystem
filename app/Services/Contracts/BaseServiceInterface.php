<?php
namespace App\Services\Contracts;
use Exception;

/**
 * Interface BaseServiceInterface
 *
 * @package App\Services
 */
interface BaseServiceInterface
{
    /**
     * Retrieve all data
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * Retrieve all data, paginated
     *
     * @param null $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate($limit = null, $columns = ['*']);

     /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function show($id, $columns = ['*']);

    /**
     * Save a new entity
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update a entity by id
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id);

    /**
     * Delete a entity by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id);

}

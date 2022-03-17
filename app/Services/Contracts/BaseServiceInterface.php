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
     * Retrieve find 1 data
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id);

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

    /**
     * Upload a file
     *
     * @param $file, $attributes
     *
     * @return boolean
     */
    public function uploadFile($file, array $attributes = []);

    /**
     * detatch a file
     *
     * @param $file, $attributes
     *
     * @return boolean
     */
    // public function detatchFile($file, array $attributes = []);

    // /**
    //  * read a file in online mode
    //  *
    //  * @param $file, $attributes
    //  *
    //  *
    //  */
    // public static function readFile();

    // /**
    //  * detatch a file
    //  *
    //  * @param $file, $attributes
    //  *
    //  * @return boolean
    //  */
    // public static function downloadFile();
}

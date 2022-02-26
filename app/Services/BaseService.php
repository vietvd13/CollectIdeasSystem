<?php
namespace Services;
use App\Services\Contracts\BaseServiceInterface;
abstract class BaseService implements BaseServiceInterface {
    protected $repository;

    public function __construct(BaseServiceInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieve all data
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*']) {
        return $this->repository->model->all();
    }

    /**
     * Retrieve all data, paginated
     *
     * @param null $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate($limit = null, $columns = ['*']) {
        return $this->repository->model->paginate($limit, $columns);
    }

     /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function show($id, $columns = ['*']) {
        return $this->repository->model->find($id, $columns);
    }

    /**
     * Save a new entity
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes) {
        return $this->repository->model->create($attributes);
    }

    /**
     * Update a entity by id
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id) {
        return $this->repository->model->update($attributes, $id);
    }

    /**
     * Delete a entity by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id) {
        return $this->repository->model->delete($id);
    }
}

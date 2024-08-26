<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get a record by ID.
     *
     * @param int $id
     * @return Model
     */
    public function findById(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new record.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing record.
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model
    {
        $record = $this->findById($id);
        $record->update($data);
        return $record;
    }

    /**
     * Soft delete a record by ID.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $record = $this->findById($id);
        $record->delete();
    }

    /**
     * Permanently delete a record by ID.
     *
     * @param int $id
     * @return void
     */
    public function forceDelete(int $id): void
    {
        $record = $this->findById($id);
        $record->forceDelete();
    }
}

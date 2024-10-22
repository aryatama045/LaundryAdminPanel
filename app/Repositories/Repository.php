<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{

    /**
     * Define relevant model
     *
     * @return Model|Builder
     */
    abstract public function model();

    /**
     * @return Builder
     */
    public function query()
    {
        return $this->model()::query();
    }

    public function getAll()
    {
        return $this->model()::all();
    }

    /**
     * @return Builder|Model|object|null
     */
    public function first()
    {
        return $this->model()::first();
    }

    /**
     * @param $primaryKey
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null|mixed
     */
    public function find($primaryKey)
    {
        return $this->model()::find($primaryKey);
    }

    /**
     * @param $primaryKey
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null|mixed
     */
    public function findOrFail($primaryKey)
    {
        return $this->model()::findOrFail($primaryKey);
    }

    public function delete($primaryKey)
    {
        return $this->model()::destroy($primaryKey);
    }

    /**
     * @param array $data
     * @return Builder|Model|mixed
     */
    public function create(array $data)
    {
        return $this->model()::create($data);
    }

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data)
    {
        return $model->update($data);
    }
}

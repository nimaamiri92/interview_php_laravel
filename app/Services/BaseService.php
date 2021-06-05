<?php


namespace App\Services;


use Illuminate\Database\Eloquent\Model;

class BaseService
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function insertOrIgnore(array $attribute)
    {
        $this->model->insertOrIgnore($attribute);
    }

    public function update(array $attributes, int $id): bool
    {
        return $this->find($id)->update($attributes);
    }

    public function delete(Model $model)
    {
        try {
            $model->delete();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}
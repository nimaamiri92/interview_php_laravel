<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

class BaseRepository
{

    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function findOneBy(array $data)
    {
        return $this->model->where($data)->first();
    }
}
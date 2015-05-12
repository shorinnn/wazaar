<?php


namespace Delivered\Repositories;


trait CommonModelMethodsTrait {
    public function create($data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }
}
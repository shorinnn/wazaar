<?php


namespace Delivered\Repositories\Client;


interface ClientInterface {
    public function find($id);
    public function create($data);
    public function all();
    public function delete($id);

    public function validationRules($id = 0);
    public function validationMessages();
}
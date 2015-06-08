<?php namespace Delivered\Repositories\ClientUser;

interface ClientUserInterface {

    public function find($id);
    public function create($data);
    public function all();
    public function delete($id);
    public function insert($batch);
    public function getByClient($clientId);

    public function validationRules($id = 0);
    public function validationMessages();

}
<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module
{
    public function __construct(){
        $this->users = new \UserRepository();    
    }
    
    public function setupDatabase() {
        \Artisan::call('migrate:refresh');
        \Artisan::call('db:seed');
    }
    
    public function refresh_user(\User $user){
        $user = $this->users->find($user->id);
        \Auth::login($user);
        return $user;
    }
}

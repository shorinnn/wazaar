<?php

class AdminDashboardController extends BaseController
{

    public function __construct()
    {
        $this->beforeFilter('admin');
    }


}
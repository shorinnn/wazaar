<?php

class AdminDashboardController extends BaseController
{

    protected $adminHelper;

    public function __construct(AdminHelper $adminHelper)
    {
        $this->beforeFilter('admin');
        $this->adminHelper = $adminHelper;
    }

    public function index()
    {
        $userCountView = $this->userCountView();
        return View::make('administration.dashboard.index', compact('userCountView'));
    }

    public function userCountView($frequency = 'today')
    {
        $userStats = $this->adminHelper->userStats($frequency);
        $view = Str::title($frequency);
        return View::make('administration.dashboard.partials.user.count' . $view, compact('frequency', 'userStats'))->render();
    }




}
@extends('layouts.default')
@section('content')
    <style>
        .sitemap .sidebar-menu,
        .sitemap{
            background: #ebeced;
            padding: 0;
        }
        .sitemap{
            padding: 55px 0;
        }
        .sidebar-menu .group ul li .dropdown-menu li a:focus,
        .sidebar-menu .group ul li .dropdown-menu li a:focus,
        .sidebar-menu .group ul li .dropdown-menu li a:hover,
        .sidebar-menu .group ul li .dropdown-menu li:hover{
            background: none !important;
            color: #798794;
        }
        .sidebar-menu .group h4{
            display: block;
            padding: 0;
            color: #303941;
            clear: both;
            margin: 0;
            font-size: 13px;
            font-weight: 600;
        }
        .sidebar-menu .group ul li .dropdown-menu{
            margin: 5px 0 23px;
        }
        @media (min-width:767px){
            .sidebar-menu .group ul li .dropdown-menu li a{
                padding: 0 0 0 13px;
                line-height: 20px;
                margin: 0;
            }
        }
        @media (min-width:767px) and (max-width: 991px){
            .sitemap .sidebar-menu{
                width: auto;
                max-width: none;
                display: inline-block;
            }
            .sidebar-menu .group ul{
                background: none;
            }
        }
    </style>
    <div class="container-fluid sitemap">
        <div class="container">
            <div class="row cat-row">
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="sidebar-menu">
                        <div class="group">
                            <ul class="main-menu clearfix category-menu-list">
                                <li class="dropdown main-menu-list hidden-sm hidden-md hidden-lg">
                                    <h4 class="dropdown-toggle category-menu-item" id="dropdownMenu-c-2"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                                <li class="dropdown main-menu-list hidden-xs open">
                                    <h4 class="category-menu-item" id="dropdownMenu-c-2">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="sidebar-menu">
                        <div class="group">
                            <ul class="main-menu clearfix category-menu-list">
                                <li class="dropdown main-menu-list hidden-sm hidden-md hidden-lg">
                                    <h4 class="dropdown-toggle category-menu-item" id="dropdownMenu-c-2"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                                <li class="dropdown main-menu-list hidden-xs open">
                                    <h4 class="category-menu-item" id="dropdownMenu-c-2">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="sidebar-menu">
                        <div class="group">
                            <ul class="main-menu clearfix category-menu-list">
                                <li class="dropdown main-menu-list hidden-sm hidden-md hidden-lg">
                                    <h4 class="dropdown-toggle category-menu-item" id="dropdownMenu-c-2"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                                <li class="dropdown main-menu-list hidden-xs open">
                                    <h4 class="category-menu-item" id="dropdownMenu-c-2">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="sidebar-menu">
                        <div class="group">
                            <ul class="main-menu clearfix category-menu-list">
                                <li class="dropdown main-menu-list hidden-sm hidden-md hidden-lg">
                                    <h4 class="dropdown-toggle category-menu-item" id="dropdownMenu-c-2"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                                <li class="dropdown main-menu-list hidden-xs open">
                                    <h4 class="category-menu-item" id="dropdownMenu-c-2">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="sidebar-menu">
                        <div class="group">
                            <ul class="main-menu clearfix category-menu-list">
                                <li class="dropdown main-menu-list hidden-sm hidden-md hidden-lg">
                                    <h4 class="dropdown-toggle category-menu-item" id="dropdownMenu-c-2"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                                <li class="dropdown main-menu-list hidden-xs open">
                                    <h4 class="category-menu-item" id="dropdownMenu-c-2">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="sidebar-menu">
                        <div class="group">
                            <ul class="main-menu clearfix category-menu-list">
                                <li class="dropdown main-menu-list hidden-sm hidden-md hidden-lg">
                                    <h4 class="dropdown-toggle category-menu-item" id="dropdownMenu-c-2"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                                <li class="dropdown main-menu-list hidden-xs open">
                                    <h4 class="category-menu-item" id="dropdownMenu-c-2">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="sidebar-menu">
                        <div class="group">
                            <ul class="main-menu clearfix category-menu-list">
                                <li class="dropdown main-menu-list hidden-sm hidden-md hidden-lg">
                                    <h4 class="dropdown-toggle category-menu-item" id="dropdownMenu-c-2"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                                <li class="dropdown main-menu-list hidden-xs open">
                                    <h4 class="category-menu-item" id="dropdownMenu-c-2">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="sidebar-menu">
                        <div class="group">
                            <ul class="main-menu clearfix category-menu-list">
                                <li class="dropdown main-menu-list hidden-sm hidden-md hidden-lg">
                                    <h4 class="dropdown-toggle category-menu-item" id="dropdownMenu-c-2"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                                <li class="dropdown main-menu-list hidden-xs open">
                                    <h4 class="category-menu-item" id="dropdownMenu-c-2">
                                        Cat Name
                                        <i class="wa-chevron-down right hidden-sm hidden-md hidden-lg"></i>
                                        <i class="wa-chevron-up hidden-sm hidden-md hidden-lg"></i>
                                    </h4>
                                    <ul class="dropdown-menu sub-category-menu-list" aria-labelledby="dropdownMenu-c-2">
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sub-categoty-menu-item" href="">
                                                    <span class="sub-category-menu-item-label">Sub cat name</span>
                                                    <i class="wa-chevron-right right hidden-sm hidden-md hidden-lg"></i>
                                                </a>
                                            </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
@stop
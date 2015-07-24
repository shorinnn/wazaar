@extends('layouts.default')
@section('content')
	<div class="container-fluid analytics-page">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top-20">
                	<div class="top-affiliates-table table-wrapper">
                    	<div class="table-header clearfix">
                        	<h1 class="left">Top Affiliates</h1>
                            <form class="right">
                            	<div class="search-affiliates">
                                	<input type="search" placeholder="Search affiliates ..." />
                                    <button><i class="wa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>Rank</th>
                                  <th>Username</th>
                                  <th>Full name</th>
                                  <th>Sales (#)</th>
                                  <th class="text-right last-column sorting-active relative"> Sales (¥)<i class="fa fa-arrow-down"></i></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <th scope="row">1</th>
                                  <td class="link">WazaarAffiliate</td>
                                  <td>Affialiate Wazaar	</td>
                                  <td>57</td>
                                  <td class="text-right last-column">  ¥ 23,624</td>
                                </tr>
                                <tr>
                                  <th scope="row" class="first-column">2</th>
                                  <td class="link">vstreich</td>
                                  <td>Feeney Aiden</td>
                                  <td>2</td>
                                  <td class="text-right last-column">¥ 64</td>
                                </tr>
                                <tr>
                                  <th scope="row" class="first-column">3</th>
                                  <td class="link">affiliate</td>
                                  <td>Instructor Wazaar</td>
                                  <td>3</td>
                                  <td class="text-right last-column">  ¥ 50</td>
                                </tr>
                                <tr>
                                  <th scope="row" class="first-column">4</th>
                                  <td class="link">eloise88</td>
                                  <td>Corkery Milford</td>
                                  <td>4</td>
                                  <td class="text-right last-column">¥ 43</td>
                                </tr>
                                <tr>
                                  <th scope="row" class="first-column">5</th>
                                  <td class="link">WazaarAffiliate	</td>
                                  <td>Affialiate Wazaar	</td>
                                  <td>4</td>
                                  <td class="text-right last-column">¥ 41</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                        <div class="table-pagination clearfix">
                        	<ul>
                            	<li class="prev">
                                	<a href="#"><i class="wa-chevron-left"></i></a>
                                </li>
                            	<li class="active">
                                	<a href="#">1</a>
                                </li>
                            	<li>
                                	<a href="#">2</a>
                                </li>
                            	<li>
                                	<a href="#">3</a>
                                </li>
                            	<li>
                                	<a href="#">4</a>
                                </li>
                            	<li>
                                	<a href="#">5</a>
                                </li>
                            	<li>
                                	<a href="#">6</a>
                                </li>
                            	<li class="next">
                                	<a href="#"><i class="wa-chevron-right"></i></a>
                                </li>
                            </ul>
                        </div>                       
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                	<div class="top-courses-table table-wrapper">
                    	<div class="table-header clearfix">
                        	<h1 class="left">Top Courses</h1>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Course Title</th>
                                  <th>Conversion</th>
                                  <th class="text-right last-column sorting-active relative"> Sales (¥)<i class="fa fa-arrow-down"></i></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <th scope="row">1</th>
                                  <td class="link">WazaarAffiliate</td>
                                  <td>57</td>
                                  <td class="text-right last-column">  ¥ 23,624</td>
                                </tr>
                                <tr>
                                  <th scope="row" class="first-column">2</th>
                                  <td class="link">vstreich</td>
                                  <td>2</td>
                                  <td class="text-right last-column">¥ 64</td>
                                </tr>
                                <tr>
                                  <th scope="row" class="first-column">3</th>
                                  <td class="link">affiliate</td>
                                  <td>3</td>
                                  <td class="text-right last-column">  ¥ 50</td>
                                </tr>
                                <tr>
                                  <th scope="row" class="first-column">4</th>
                                  <td class="link">eloise88</td>
                                  <td>4</td>
                                  <td class="text-right last-column">¥ 43</td>
                                </tr>
                                <tr>
                                  <th scope="row" class="first-column">5</th>
                                  <td class="link">WazaarAffiliate	</td>
                                  <td>4</td>
                                  <td class="text-right last-column">¥ 41</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                    </div>
                
                </div>
            	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                	<div class="top-tracking-codes-table table-wrapper">
                    	<div class="table-header clearfix">
                        	<h1 class="left">Top Tracking Codes</h1>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Course Title</th>
                                  <th>Clicks</th>
                                  <th class="text-right last-column sorting-active relative"> Conversion<i class="fa fa-arrow-down"></i></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <th scope="row">1</th>
                                  <td class="link">WazaarAffiliate</td>
                                  <td>57</td>
                                  <td class="text-right last-column">  99%</td>
                                </tr>
                                <tr>
                                  <th scope="row" class="first-column">2</th>
                                  <td class="link">vstreich</td>
                                  <td>2</td>
                                  <td class="text-right last-column">99%</td>
                                </tr>
                                <tr>
                                  <th scope="row" class="first-column">3</th>
                                  <td class="link">affiliate</td>
                                  <td>3</td>
                                  <td class="text-right last-column">  99%</td>
                                </tr>
                                <tr>
                                  <th scope="row" class="first-column">4</th>
                                  <td class="link">eloise88</td>
                                  <td>4</td>
                                  <td class="text-right last-column">99%</td>
                                </tr>
                                <tr>
                                  <th scope="row" class="first-column">5</th>
                                  <td class="link">WazaarAffiliate	</td>
                                  <td>4</td>
                                  <td class="text-right last-column">99%</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>	
@stop

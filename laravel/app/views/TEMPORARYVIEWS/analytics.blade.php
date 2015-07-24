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
                                    <th class="text-right"> Sales (¥)</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <th scope="row">1</th>
                                    <td class="link">WazaarAffiliate</td>
                                    <td>Affialiate Wazaar	</td>
                                    <td>57</td>
                                    <td class="text-right">  ¥ 23,624</td>
                                  </tr>
                                  <tr>
                                    <th scope="row">2</th>
                                    <td class="link">vstreich</td>
                                    <td>Feeney Aiden</td>
                                    <td>2</td>
                                    <td class="text-right">¥ 64</td>
                                  </tr>
                                  <tr>
                                    <th scope="row">3</th>
                                    <td class="link">affiliate</td>
                                    <td>Instructor Wazaar</td>
                                    <td>3</td>
                                    <td class="text-right">  ¥ 50</td>
                                  </tr>
                                  <tr>
                                    <th scope="row">4</th>
                                    <td class="link">eloise88</td>
                                    <td>Corkery Milford</td>
                                    <td>4</td>
                                    <td class="text-right">¥ 43</td>
                                  </tr>
                                  <tr>
                                    <th scope="row">5</th>
                                    <td class="link">WazaarAffiliate	</td>
                                    <td>Affialiate Wazaar	</td>
                                    <td>4</td>
                                    <td class="text-right">¥ 41</td>
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

<h3>Top Affiliates</h3>
<hr/>
{{Form::open(['action' => 'AdminDashboardController@index'])}}
<div class="row margin-bottom-20">

    <div class="col-md-2">
        <h4 class="date-range-header">Date Range</h4>
    </div>

    <div class='col-md-2'>
        <div class="form-group">
            <div class='input-group date' id='start-date'>
                <input type='text' class="form-control" id="startDate" name="taStartDate" value="{{!empty($taStartDate) ? $taStartDate : ''}}" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
            </div>
        </div>
    </div>

    <div class='col-md-2'>
        <div class="form-group">
            <div class='input-group date' id='end-date'>
                <input type='text' class="form-control" id="endDate" name="taEndDate" value="{{!empty($taEndDate) ? $taEndDate : ''}}"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
            </div>
        </div>
    </div>

    <div class='col-md-3'>
        <div class="form-group">
            {{Form::select('affiliateId',ProductAffiliate::profileLists(),$affiliateId,['class' => 'form-control', 'id' => 'affiliateId'])}}
        </div>
    </div>

    <div class="col-md-3">
        <button class="btn btn-primary" id="btn-update-chart">Apply Filter</button>
    </div>
</div>
{{Form::close()}}
<table class="table table-striped">
    <tbody>
        <th>Rank</th>
        <th>Username</th>
        <th>Full Name</th>
        <th>Sales(#)</th>
        <th>Sales(¥)</th>
    </tbody>
    <tbody>
        @foreach($topAffiliates as $index => $aff)
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$aff->username}}</td>
                <td>{{$aff->full_name}}</td>
                <td>{{$aff->sales_count}}</td>
                <td>¥{{number_format($aff->total_sales)}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<?php Paginator::setPageName('page_aff'); ?>
{{$topAffiliates->appends(Input::only('startDate','endDate','affiliateId'))->links()}}
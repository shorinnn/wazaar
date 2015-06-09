<h3>Top Affiliates</h3>
<hr/>
{{Form::open(['id' => 'form-affiliates'])}}
<div class="row margin-bottom-20">

    <div class="col-md-1">
        <h4 class="date-range-header">Filter</h4>
    </div>

    <div class='col-md-2'>
        <div class="form-group">
            <div class='input-group date' id='start-date'>
                <input type='text' class="form-control" id="startDate" placeholder="{{trans('analytics.alltime')}}" name="taStartDate" value="{{!empty($taStartDate) ? $taStartDate : ''}}" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
            </div>
        </div>
    </div>

    <div class='col-md-2'>
        <div class="form-group">
            <div class='input-group date' id='end-date'>
                <input type='text' class="form-control" id="endDate" placeholder="{{trans('analytics.alltime')}}" name="taEndDate" value="{{!empty($taEndDate) ? $taEndDate : ''}}"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
            </div>
        </div>
    </div>

    <div class='col-md-2'>
        <div class="form-group">
            {{Form::select('affiliateId',ProductAffiliate::profileLists(),0,['class' => 'form-control', 'id' => 'affiliateId'])}}
        </div>
    </div>

    <div class='col-md-3'>
        <div class="form-group">
            {{Form::select('sortOrder', AdminHelper::sortOptions() ,0,['class' => 'form-control', 'id' => 'sortOrder'])}}
        </div>
    </div>


    <div class="col-md-2">
        <button type="button" class="btn btn-primary" id="btn-apply-filter-affiliates" data-loading-text="Loading...">Apply Filter</button>
    </div>
</div>
{{Form::close()}}
<div class="affiliates-table-and-pagination">
    {{$topAffiliatesTable}}
</div>
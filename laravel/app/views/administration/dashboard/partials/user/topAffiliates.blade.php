<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top-20">
        <div class="top-affiliates-table table-wrapper">
            <div class="table-header clearfix">
                <h1 class="left">Top Affiliates</h1>

            </div>
    {{Form::open(['id' => 'form-affiliates'])}}
    <div class="row margin-bottom-20">

        <div class="col-md-1">
            <h4 class="date-range-header">Filter</h4>
        </div>

        <div class='col-md-2'>
            <div class="form-group">
                <div class='input-group date input-group-sm' id='start-date'>
                    <input type='text' class="form-control" id="startDate" placeholder="{{trans('analytics.alltime')}}" name="taStartDate" value="{{!empty($taStartDate) ? $taStartDate : ''}}" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                </div>
            </div>
        </div>

        <div class='col-md-2'>
            <div class="form-group">
                <div class='input-group date input-group-sm' id='end-date'>
                    <input type='text' class="form-control" id="endDate" placeholder="{{trans('analytics.alltime')}}" name="taEndDate" value="{{!empty($taEndDate) ? $taEndDate : ''}}"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                </div>
            </div>
        </div>

        <div class='col-md-2'>
            <div class="form-group">
                {{Form::select('affiliateId',ProductAffiliate::profileLists(),0,['class' => 'form-control input-sm', 'id' => 'affiliateId'])}}
            </div>
        </div>

        <div class='col-md-3'>
            <div class="form-group">
                {{Form::select('sortOrder', AdminHelper::sortOptions() ,0,['class' => 'form-control input-sm', 'id' => 'sortOrder'])}}
            </div>
        </div>


        <div class="col-md-2">
            <button type="button" class="btn btn-default btn-sm" id="btn-apply-filter-affiliates" data-loading-text="Loading...">Apply Filter</button>
        </div>
    </div>
    {{Form::close()}}
    <div class="affiliates-table-and-pagination">
        {{$topAffiliatesTable}}
    </div>


        </div>
    </div>

</div>

<div class="top-courses-table table-wrapper">
    <div class="table-header clearfix">
        <h1 class="left">Top Courses ({{$freeCourse == 'no' ? 'Paid' : 'Free'}})</h1>
    </div>

    {{Form::open(['id' => 'form-courses-' . $freeCourse])}}
    <div class="row margin-bottom-20">



        <div class='col-md-2'>
            <div class="form-group">
                <div class='input-group date input-group-sm' id='start-date'>
                    <input type='text' class="form-control" id="startDate-{{$freeCourse}}" name="endDate" placeholder="{{trans('analytics.alltime')}}" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class='col-md-2'>
            <div class="form-group">
                <div class='input-group date input-group-sm' id='end-date'>
                    <input type='text' class="form-control" id="endDate-{{$freeCourse}}" name="endDate" placeholder="{{trans('analytics.alltime')}}" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class='col-md-2'>
            <div class="form-group">
                {{Form::select('categoryId',['']+CourseCategory::all()->lists('name','id'),0,['class' => 'form-control input-sm', 'id' => 'categoryId'])}}
            </div>
        </div>

        <div class='col-md-3'>
            <div class="form-group">
                {{Form::select('sortOrder', AdminHelper::sortOptions() ,0,['class' => 'form-control input-sm', 'id' => 'sortOrder'])}}
            </div>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary btn-sm" type="button" id="btn-apply-filter-courses-{{$freeCourse}}">Apply Filter</button>
        </div>
    </div>
    {{Form::close()}}


    {{$topCoursesTableView}}

</div>


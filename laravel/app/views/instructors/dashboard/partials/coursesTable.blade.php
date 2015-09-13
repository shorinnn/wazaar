<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top-20">
    <div class="top-affiliates-table table-wrapper">
        <div class="table-header clearfix">
            <h1 class="left">Courses</h1>

        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="50%">{{trans('profile.form.name')}}</th>
                    <th width="20%">{{trans('analytics.enrolled')}}</th>
                    <th width="20%">{{trans('analytics.sales')}}</th>
                    <th width="10%">{{trans('courses/general.price')}}</th>
                </tr>
                </thead>

                <tbody>

                @foreach($courses as $course)
                    <tr>
                        <th class="link" scope="row">
                            @if ($course->free == 'no')
                                <a href="{{url('analytics/course/' . $course->slug)}}">{{$course->name}}</a>
                            @else
                                {{$course->name}}
                            @endif
                        </th>
                        <td>{{$course->sales->count()}}</td>
                        <td>
                            @if ($course->free == 'no')
                                ¥ {{number_format($course->sales->sum('instructor_earnings'))}}
                            @else
                               N/A
                            @endif

                        </td>
                        <td>
                            @if ($course->free == 'no')
                                ¥ {{number_format($course->price)}}
                            @else
                                {{trans('courses/create.free')}}
                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top-20">
    <div class="top-affiliates-table table-wrapper">
        <div class="table-header clearfix">
            <h1 class="left">{{trans('analytics.courses')}}</h1>

        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="50%">{{trans('instructors/analytics.name')}}</th>
                    <th width="15%" style="text-align: center">{{trans('analytics.salesCount')}}</th>
                    <th width="15%" style="text-align: center">{{trans('instructors/analytics.sales-revenue')}}</th>
                    <th width="10%" style="text-align: center">{{trans('analytics.tax')}}</th>
                    {{--<th width="10%" style="text-align: center">{{trans('instructors/analytics.price')}}</th>--}}
                </tr>
                </thead>

                <tbody>

                @if ($courses->count() > 0)


                        @foreach($courses as $course)
                            <tr>
                                <th class="link" scope="row">
                                    @if ($course->free == 'no')
                                        <a href="{{url('analytics/course/' . $course->slug)}}">{{$course->name}}</a>
                                    @else
                                        <span style="color:#000">{{$course->name}}</span>
                                    @endif
                                </th>
                                <td align="center">{{$course->sales->count()}}</td>
                                <td align="center">
                                    @if ($course->free == 'no')
                                        ¥ {{number_format($course->sales->sum('instructor_earnings'))}}
                                    @else
                                       N/A
                                    @endif

                                </td>
                                <td align="center">
                                    @if ($course->free == 'no')
                                        ¥ {{number_format($course->sales->sum('tax'))}}
                                    @else
                                        N/A
                                    @endif

                                </td>
                                {{--
                                <td align="center">
                                    @if ($course->free == 'no')
                                        ¥ {{number_format($course->price)}}
                                    @else
                                        {{trans('courses/create.free')}}
                                    @endif
                                </td>--}}
                            </tr>
                        @endforeach
                @else
                    <tr>
                        <td colspan="4">{{trans('analytics.noCourses')}}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

    </div>
</div>
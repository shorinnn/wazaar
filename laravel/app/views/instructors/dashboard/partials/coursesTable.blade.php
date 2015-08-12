<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-top-20">
    <div class="top-affiliates-table table-wrapper">
        <div class="table-header clearfix">
            <h1 class="left">Courses</h1>
            <form class="right">
                <div class="search-affiliates">
                    <input type="search" placeholder="Search affiliates ...">
                    <button><i class="wa-search"></i></button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
                </thead>

                <tbody>

                @foreach($courses as $course)
                    <tr>
                        <th class="link" scope="row"><a href="{{url('analytics/course/' . $course->slug)}}">{{$course->name}}</a></th>
                        <td>{{$course->short_description}}</td>
                        <td>¥ {{number_format($course->price)}}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

    </div>
</div>
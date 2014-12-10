    @extends('layouts.default')
    @section('content')	

        <section class="container">

            <div class="row first-row">
                @foreach($categories as $category)
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="category-heading">         
                        <div class="clearfix">
                            <p class="lead"> {{ $category->name }} <small>{{ $category->description }}</small></p>
                            
                            <a href="{{ action('CoursesController@category', $category->slug) }}">View all</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            {{ $categories->links() }}
        </section>

    @stop
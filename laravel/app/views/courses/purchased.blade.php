    @extends('layouts.default')
    
    @section('page_title')
    {{ $course->name }} -
    @stop
    
    @section('content')	
        <section class="main-content-container clearfix">          
            
                <section class="container-fluid description">
                    <div class="container">
                      <div class="row">
                        <div class="col-xs-12">
                            {{trans('courses/general.you-have-enrolled')}}<br />
                              <h1>{{ $course->name }}</h1>
                              <a class='btn btn-primary' 
                                 href='{{ action( 'ClassroomController@dashboard', $course->slug ) }}'>{{trans('courses/general.begin-my-learning')}}</a>
                        </div>
                      </div>
                  </div>
                </section>
        </section>
    
    @stop
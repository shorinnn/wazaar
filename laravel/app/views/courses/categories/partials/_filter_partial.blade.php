<div class="container-fluid category-heading-container">
    <div class="container-fluid cat-row-{{$category->color_scheme}}">
        <div class="row category-heading">
            <form id="course-filter-form">
                <div class="filters">
                    <div class="clearfix category-heading-buttons">
                        <div class="sort-options clearfix"><label>Sort by:</label>
                            {{ Form::select('sort', CourseHelper::getCourseSortOptions(), Input::get('sort'), ['class' => 'form-control course-sort', 'onchange'=>"loadFilteredCourseCategory();"] ) }}
                        </div>

                        <div class="segmented-controls clearfix course-filters">
                            <div class="segmented-buttons-wrapper segmented-controls inline-block clearfix">
                                <div class="btn-group buttons-container" data-toggle="buttons">
                                    <label class="btn btn-default segmented-buttons @if(empty(Input::get('filter')) || Input::get('filter') == 'all' ) active @endif">
                                        <input type="radio" name="filter" value="all" class="filter" autocomplete="off" 
                                        @if(empty(Input::get('filter')) || Input::get('filter') == 'all' ) checked='checked' @endif
                                        onchange="loadFilteredCourseCategory();"> {{ trans('courses/general.filter.all') }}
                                    </label>
                                    <label class="btn btn-default segmented-buttons @if(!empty(Input::get('filter')) && Input::get('filter') == 'paid' ) active @endif">
                                        <input type="radio" name="filter" value="paid" class="filter" autocomplete="off" 
                                        @if(!empty(Input::get('filter')) && Input::get('filter') == 'paid' ) checked='checked' @endif
                                        onchange="loadFilteredCourseCategory();"> {{ trans('courses/general.filter.paid') }}
                                    </label>
                                    <label class="btn btn-default segmented-buttons @if(!empty(Input::get('filter')) && Input::get('filter') == 'free' ) active @endif">
                                        <input type="radio" name="filter" value="free" class="filter" autocomplete="off" 
                                        @if(!empty(Input::get('filter')) && Input::get('filter') == 'free' ) checked='checked' @endif
                                        onchange="loadFilteredCourseCategory();"> {{ trans('courses/general.filter.free') }}
                                    </label>
                                </div>
                            </div>
                            <div class="segmented-buttons-wrapper segmented-controls inline-block clearfix">
                                <div class="btn-group buttons-container" data-toggle="buttons">
                                    <label class="btn btn-default segmented-buttons @if(empty(Input::get('difficulty')) || Input::get('difficulty') == '0' ) active @endif">
                                        <input type="radio" name="difficulty" value="0" class="difficulty" autocomplete="off" checked="checked" onchange="loadFilteredCourseCategory();"> {{ trans('courses/general.filter.all') }}
                                    </label>
                                    <label class="btn btn-default segmented-buttons @if(!empty(Input::get('difficulty')) && Input::get('difficulty') == '1' ) active @endif">
                                        <input type="radio" name="difficulty" value="1" class="difficulty" autocomplete="off" onchange="loadFilteredCourseCategory();"> {{ trans('courses/general.filter.beginner') }}
                                    </label>
                                    <label class="btn btn-default segmented-buttons @if(!empty(Input::get('difficulty')) && Input::get('difficulty') == '2' ) active @endif">
                                        <input type="radio" name="difficulty" value="2" class="difficulty" autocomplete="off" onchange="loadFilteredCourseCategory();"> {{ trans('courses/general.filter.advanced') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
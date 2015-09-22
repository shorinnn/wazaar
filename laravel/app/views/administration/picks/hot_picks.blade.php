@extends('layouts.default')

@section('content')	
<style>
    .search-course-container{
        padding-bottom: 10px;
    }
    .select2-search__field{
        width: 95% !important;
    }
    .order-list-input{
        width: 75% !important;
        display: block !important;
        margin: 0px auto;
        text-align: center;
    }
    .save-order{
        color: #fff;
    }
    .course_checkbox{
        float: none !important;
        margin: 0px auto !important;
        opacity: 1 !important;
        display: block !important;
    }
</style>

<div class="container course-categories">
	<div class="row">
    	<div class="col-md-12">
            <h1 class='icon'>Hot Picks</h1>
        </div>
    </div>
</div>
<div class="container">
	<div class="row">
    	<div class="col-md-12">
            <div class="search-course-container">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" onclick="add_courses_to_list();">Add</button>
                    </span>
                    {{Form::select('search-course', $courses, null, ['id'=>'search-course', 'class'=>'form-control pretty-select', 'multiple'=> 'multiple'])}}
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="text-center alax-loader hide"><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></div>
            <div class="hot-picks-listings-container"></div>
		</div>
	</div>
</div>

@stop

@section('extra_js')
<script>
    function add_courses_to_list()
    {
        $.ajax({
            url: '/administration/add-to-picks/hot-picks',
            method: 'post',
            data: {
                ids : $('#search-course').val()
            },
            cache: false,
            success: function(result){
                load_picked_courses();
                $('#search-course').val('')
                $('.select2-selection__choice').remove()
            }
        });

    }
    function load_picked_courses()
    {
        $('.alax-loader').hide().removeClass('hide').show();
        $.ajax({
            url: '/administration/load-picks/hot-picks',
            cache: false,
            success: function(result){
                $('.alax-loader').hide();
                $('.hot-picks-listings-container').html(result);
            }
        });
    }

    function deleteCourses()
    {
        if($('tbody .course_checkbox:checked').length >= 1){
            $('#picks-list-form')
            .append('<input type="hidden" class="delete_method" name="_method" value="DELETE" />')

            var $formData = $('#picks-list-form').serialize();
            $('.alax-loader').show();
            $.post('/administration/delete-picks/hot-picks', $formData, function (response){
                load_picked_courses();
            });

        } else {
            alert('Please select a course to delete');
        }
    }

    function saveOrder()
    {
        var $formData = $('#picks-list-form').serialize();
        $('.alax-loader').show();
        $.post($('#picks-list-form').attr('action'), $formData, function (response){
            load_picked_courses();
        });
    }

    function toggleCheckboxes(el)
    {
        if($(el).is(':checked')){
            $('tbody .course_checkbox').prop('checked', true)
        } else {
            $('tbody .course_checkbox').prop('checked', false)
        }
    }

    jQuery(document).ready(function($){
        load_picked_courses();
        $('.pretty-select').select2({
            placeholder: "Search a Course"            
        });
    });
</script>
@stop
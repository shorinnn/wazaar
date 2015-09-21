@extends('layouts.default')

@section('content')	
<style>
    .search-course-container{
        padding-bottom: 10px;
    }
    .order-list-input{
        width: 50% !important;
        display: block !important;
        margin: 0px auto;
        text-align: center;
    }
    .save-order{
        color: #000;
    }
</style>

<div class="container course-categories">
	<div class="row">
    	<div class="col-md-12">
            <h1 class='icon'>Wazaar Picks</h1>
        </div>
    </div>
</div>
<div class="container">
	<div class="row">
    	<div class="col-md-12">
            <div class="row col-md-12 search-course-container">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" onclick="add_courses_to_list();">Add</button>
                    </span>
                    <select id="search-course" class="form-control pretty-select" multiple="multiple" size="1"></select>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="text-center alax-loader hide"><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></div>
            <div class="wazaar-picks-listings-container"></div>
		</div>
	</div>
</div>

@stop

@section('extra_js')
<script>
    function add_courses_to_list()
    {
        $.ajax({
            url: '/administration/add-to-picks/wazaar-picks',
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
            url: '/administration/load-picks/wazaar-picks',
            cache: false,
            success: function(result){
                $('.alax-loader').hide();
                $('.wazaar-picks-listings-container').html(result);
            }
        });
    }

    jQuery(document).ready(function($){
        load_picked_courses();
        $('.pretty-select').select2({
            placeholder: "Search a Course",
            ajax: {
                url: "/administration/load-courses/wazaar-picks",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, page) {
                    // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data
                    return {
                        results: data.items
                    };
                },
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 1
        });
    });
</script>
@stop
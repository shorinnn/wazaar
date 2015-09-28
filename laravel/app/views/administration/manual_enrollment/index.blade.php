@extends('layouts.default')
@section('content')

    @if (Session::get('success'))
        <div class="alert alert-success">{{{ Session::get('success') }}}</div>
    @endif
    @if (Session::get('error'))
        <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
    @endif
    <style>
        .overlay-loading{
            position:absolute;
            margin-left:auto;
            margin-right:auto;
            left:0;
            right:0;
            z-index: 10;
            width:32px;
            height:32px;
            background-image:url('http://www.mytreedb.com/uploads/mytreedb/loader/ajax_loader_blue_32.gif');
        }
    </style>



    <div class="container members-area  ajax-content">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Manually Enroll Student</h3>
                </div>
                <div class="panel-body">
                {{Form::open(['class' => 'form-horizontal', 'id' => 'form-enroll'])}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Student Name: </label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $student->firstName() }}, {{ $student->lastName() }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email: </label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{$student->email}}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Course: </label>
                        <div class="col-sm-8">
                            <input type="text" name="course" id="course" autocomplete="off" disabled>
                            <button class="btn btn-sm" id="btn-search-course">Search Course</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Price: </label>
                        <div class="col-sm-3">
                            <input type="text" name="price" id="price">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-primary" id="btn-enroll">Enroll</button>
                            <button type="button" class="btn btn-warning" onclick="window.location='{{url('administration/members')}}'">Cancel</button>
                        </div>
                    </div>
                    {{Form::hidden('courseId')}}
                    {{Form::hidden('studentId',$student->id)}}
                {{Form::close()}}
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade modal-wide" id="modal-courses">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Select Course</h4>
                </div>
                <div class="modal-body">
                    <table id="table-courses" class="table table-bordered">
                        <thead>
                            <th>Course Name</th>
                            <th>Price</th>
                            <th></th>
                        </thead>

                        <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td>{{$course->name}}</td>
                                    <td>¥{{$course->price}}</td>
                                    <td><button class="btn btn-primary btn-select-course" data-course-id="{{$course->id}}" data-course-name="{{$course->name}}" data-course-price="{{$course->price}}">Select</button></td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@stop

@section('extra_css')

    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/1.10.6/integration/bootstrap/3/dataTables.bootstrap.css"/>
    <style type="text/css">
        .modal.modal-wide .modal-dialog {
            width: 90%;
        }
        .modal-wide .modal-body {
            overflow-y: auto;
        }

    </style>
@stop


@section('extra_js')
    <script type="text/javascript" src="{{url('plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.6/integration/bootstrap/3/dataTables.bootstrap.js"></script>


    <script type="text/javascript">
        $(function(){

            $('#btn-search-course').on('click', function($e){
                $e.preventDefault();
                $('#modal-courses').modal('show');
            });

            $('#table-courses').DataTable();

            $(".modal-wide").on("show.bs.modal", function() {
                var height = $(window).height() - 200;
                $(this).find(".modal-body").css("max-height", height);
            });

            $('body').delegate('.btn-select-course', 'click', function(){
                var $courseId = $(this).attr('data-course-id');
                var $courseName = $(this).attr('data-course-name');
                var $coursePrice = $(this).attr('data-course-price');
                $('#modal-courses').modal('hide');

                $('#course').val($courseName);
                $('#price').val($coursePrice);
                $('input[name=courseId]').val($courseId);
            });

            $('#btn-enroll').on('click', function(){

                var $courseId = $('input[name=courseId]').val();
                var $price = $('#price').val();

                if (isNaN($courseId) || $courseId == ''){
                    bootbox.alert('You must choose a course to enroll the student to');return;
                }

                if (isNaN($price)){
                    bootbox.alert('Price is invalid');return;
                }

                $('#form-enroll').submit();
            });
        });
    </script>
@stop
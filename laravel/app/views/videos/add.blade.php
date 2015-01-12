@extends('layouts.default')

@section('extra_css')
    <style type="text/css">
        .upload-drop-zone {
            height: 200px;
            border-width: 2px;
            margin-bottom: 20px;
        }

        /* skin.css Style*/
        .upload-drop-zone {
            color: #ccc;
            border-style: dashed;
            border-color: #ccc;
            line-height: 200px;
            text-align: center
        }
        .upload-drop-zone.drop {
            color: #222;
            border-color: #222;
        }
    </style>
@stop

@section('content')
    <div class="row-fluid">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Videos</strong> <small>Upload videos here</small></div>
            <div class="panel-body">

                <!-- Standar Form -->
                <h4>Select files from your computer</h4>
                {{Form::open(['url' => 'video/upload', 'id' => '', 'files' => true])}}
                    <div class="form-inline">
                        <div class="form-group">
                            <input type="file" name="fileupload" id="fileupload" multiple>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary" id="js-upload-submit">Upload files</button>
                    </div>
                {{Form::close()}}

                <!-- Drop Zone -->
                <h4>Or drag and drop files below</h4>
                <div class="upload-drop-zone" id="dropzone">
                    Just drag and drop files here
                </div>

                <!-- Progress Bar -->
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                        <span class="sr-only">60% Complete</span>
                    </div>
                </div>

                <!-- Upload Finished -->
                <div class="upload-finished hide">
                    <h3>Processed files</h3>
                    <div class="list-group">

                    </div>

                    <div id="video-formats">
                        {{-- TODO: Replace the source image url with our own, just borrowing the gif for demo purposes --}}
                        <div id="processing-message"><img height="80px" src="http://apps.nea.gov/GrantSearch/images/ajaxSpinner.gif" alt=""/> We are still processing the videos, please wait....</div>
                        <table class="table table-striped hide" id="table-video-formats">
                            <thead>
                                <th>Thumbnail</th>
                                <th>URL</th>
                                <th>Duration</th>
                                <th>Resolution</th>
                            </thead>

                            <tbody id="tbody-video-formats"></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- /container -->

    <div id="completed-notification-template" class="hide">
        <a href="#" class="list-group-item list-group-item-success"><span class="badge alert-success pull-right">Success</span>_FILENAME_</a>
    </div>
@stop

@section('extra_js')
    <script src="{{url('plugins/uploader/js/vendor/jquery.ui.widget.js')}}"></script>
    <script src="{{url('plugins/uploader/js/jquery.iframe-transport.js')}}"></script>
    <script src="{{url('plugins/uploader/js/jquery.fileupload.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('#fileupload').fileupload({
                dropZone: $('#dropzone')
            }).on('fileuploadprogress', function (e, data) {
                var $progress = parseInt(data.loaded / data.total * 100, 10);
                console.log($progress)
                $('.progress-bar').css('width', $progress + '%');
            }).on('fileuploadfail', function (e, data) {
                $.each(data.files, function (index) {
                    var error = $('<span class="text-danger"/>').text('File upload failed.');
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                });
            }).on('fileuploaddone', function (e,data){
                $('.upload-finished').removeClass('hide');
                var $notificationItem = $('#completed-notification-template').html();
                $notificationItem = $notificationItem.replace('_FILENAME_', data.files[0].name);
                $('.list-group').append($notificationItem);
                if (data.result.videoId !== undefined) {
                    Video.IntervalId = setInterval (function() { Video.GetVideo(data.result.videoId) }, 5000);
                }
            });

        });


        var Video = {
            'IntervalId' : 0,
            'GetVideo' : function ($videoId){
                $.ajax({
                    dataType: "json",
                    url: '/video/' + $videoId + '/json',
                    success: function ($jsonObj){
                        var $row = '';
                        if ($jsonObj.formats.length > 0){
                            for(var $i = 0; $i < $jsonObj.formats.length; $i++){
                                $row = '<tr>' +
                                          '<td><img src="'+ $jsonObj.formats[$i].thumbnail +'"/></td>' +
                                            '<td><video controls><source src="'+ $jsonObj.formats[$i].video_url +'" type="video/mp4"></video></td>' +
                                            '<td>'+ $jsonObj.formats[$i].duration +'</td>' +
                                            '<td>'+ $jsonObj.formats[$i].resolution +'</td>'+
                                        '</tr>';
                                $('#tbody-video-formats').append($row);
                            }

                            $('#processing-message').hide();
                            $('#table-video-formats').removeClass('hide');
                            clearInterval(Video.IntervalId);
                        }
                    }
                });
            }
        }

    </script>


@stop
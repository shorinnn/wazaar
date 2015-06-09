    @extends('layouts.default')
    
    @section('page_title')
    {{ trans('courses/promote.promote') }} {{ $course->name }} -
    @stop
    
    @section('content')	

        <section class="main-content-container clearfix">
                <section class="container-fluid description" style='background-color:white'>
                    <div class="container">
                      <div class="row">
                        <div class="col-xs-12">
                            <h2>{{ $course->name }}</h2>
                            <p class='text-center'>
                                {{ trans('courses/promote.your-link') }}:<br />
                                <div class='tooltipable'>
                                    <input type='text' class='form-control clipboardable' style='width:90%; float:left'
                                           value='{{action('CoursesController@show', $course->slug)}}?aid={{Auth::user()->affiliate_id}}'
                                           data-clipboard-text='{{action('CoursesController@show', $course->slug)}}?aid={{Auth::user()->affiliate_id}}' />
                                    <button class='btn btn-primary clipboardable'
                                            data-clipboard-text='{{action('CoursesController@show', $course->slug)}}?aid={{Auth::user()->affiliate_id}}'>
                                    {{ trans('courses/promote.copy') }}</button>
                                    <br class='clearfix' />
                                </div>
                            </p>
                            
                            {{ Form::open([ 'action' => 'GiftsController@store', 'class' => 'ajax-form', 'data-callback '=> 'addGift' ]) }}
                                <button type='submit' class='btn btn-primary'> {{ trans('courses/promote.add-gift') }}</button>
                                <input type='hidden' name='course_id' value='{{ $course->id }}' />
                            {{ Form::close() }}
                            <div id='gifts'>
                                @foreach($course->gifts as $gift)
                                    {{ View::make('affiliate.promote.partials.gift')->with( compact('gift', 'course') ) }}
                                @endforeach
                            </div>
                        </div>
                      </div>
                  </div>
                </section>            
        </section>
    
    @stop
    
    
    @section('extra_js')
    <script src="{{url('plugins/uploader/js/vendor/jquery.ui.widget.js')}}" type="text/javascript"></script>
    <script src="{{url('plugins/uploader/js/jquery.iframe-transport.js')}}" type="text/javascript"></script>
    <script src="{{url('plugins/uploader/js/jquery.fileupload.js')}}" type="text/javascript"></script>
    <script>
        function enableRTE(selector){
                tinymce.remove(selector);
                tinymce.init({
                    autosave_interval: "20s",
                    autosave_restore_when_empty: true,
                    selector: selector,
                    save_onsavecallback: function() {
                        savingAnimation(0);
                        $(selector).closest('form').submit();
                        savingAnimation(1);
                        return true;
                    },

                    plugins: [
                        "advlist autolink autosave lists link image charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste save"
                    ],
                    toolbar: "save | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                });
        }
        
        function addGift(json){
            $('#gifts').append(json.html);
            enableRTE( json.id );
            enableClipboard();
            enableFileUploader( $(json.id).parent().parent().find( '[type=file]') );
            $('html, body').animate( { scrollTop: $(json.id).parent().parent().offset().top }, 500);
        }
        
        function giftFileUploaded(e, data){
            var progressbar = $(e.target).attr('data-progress-bar');
            $(progressbar).find('span').html('');
            $(progressbar).css('width', 0 + '%');
            result = JSON.parse(data.result);
            if(result.status=='error'){
                $(e.target).after("<p class='alert alert-danger ajax-error'>"+result.errors+'</p>');
                return false;
            }
            dest = $(e.target).attr('id');
            $('.'+dest).append(result.html);
        }

        $(function(){
            $('textarea').each(function(){
                enableRTE( '#'+$(this).attr('id') );
            });
            $('[type=file]').each(function(){
                enableFileUploader( $(this) );
            });
            
        });
    </script>
    @stop
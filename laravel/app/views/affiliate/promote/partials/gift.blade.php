<div class="wrap  gift-{{ $gift->id }}">
    <h6> {{trans('affiliates.gifts.title') }}
            {{ Form::open(array('action' => ['GiftsController@destroy', $gift->id], 'method' => 'delete', 
                        'class' => 'ajax-form inline-block pull-right', 'data-callback' => 'deleteItem', 'data-delete' => '.gift-'.$gift->id )) }}
                        
                        <button type='submit' name="delete-gift-{{$gift->id}}" class="delete-button" 
                            data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class="fa fa-trash"></i>
                            {{ trans('crud/labels.delete') }} 
                        </button>
            {{ Form::close() }}
    </h6>
    {{ Form::open( ['action' => ['GiftsController@update', $gift->id], 'method' => 'PUT', 'class' => 'ajax-form' ] ) }}
    <input type="text" name='title' placeholder="{{ trans( 'affiliates.gifts.gift-number', ['number' => 1] ) }}" value='{{$gift->title}}'>
    <h6> {{trans('affiliates.gifts.message') }} 
        <!--<span class="characters-left">178 Characters left</span>-->
    </h6>
    <input type="text" name='text' placeholder="{{trans('affiliates.gifts.what-do-you-have-to-say') }}"  value='{{$gift->text}}'>
    <div class="text-center"><button type='submit' class='large-button blue-button'>{{trans('affiliates.gifts.save') }}</button></div>
    {{ Form::close() }}
    <h6>{{trans('affiliates.gifts.gift-link') }}</h6>
    <form class="relative">
        <?php
            $url  = action('CoursesController@show', $course->slug) .'?aid='.Auth::user()->affiliate_id.'&gid='.$gift->encryptedID();
            if($tcode!='') $url.= '&tcode='.$tcode;
        ?>
        <input type="text" readonly="readonly" class="copy-link" value="{{ $url }}" />
    </form>
    <div class='row'>
        <div class="dropzone @if($gift->files->count() > 0) col-lg-3 @endif">
            <i class="fa fa-cloud-upload"></i>
            <p class="regular-paragraph dropzone-{{$gift->id}}">
                <span class="semibold-text block">{{trans('affiliates.gifts.drag-and-drop') }} </span>
                {{trans('affiliates.gifts.files-to-upload') }} 
            </p>


            <form method='post' class='ajax-form clearfix' action='{{action('GiftsFileController@store')}}'>
                <input type='hidden' name='_token' value='{{ csrf_token() }}' />
                <input type='hidden' name='gift' value='{{ $gift->id }}' />

                <label for="file-upload-{{$gift->id}}" class="default-button large-button select-file">
                    <span><i class="fa fa-paperclip"></i> {{ trans('courses/create.select-file') }}</span>
                    <input type="file" hidden="" class="hide" data-upload-url=""  data-gift-id='{{$gift->id}}'
                          name='file' id='file-upload-{{$gift->id}}' data-dropzone='.dropzone-{{$gift->id}}'
                   data-progress-bar='.progress-bar-{{$gift->id}}' data-callback='giftFileUploaded'>

                </label>


            </form>
        </div>
        <div class='files-wrapper @if($gift->files->count() > 0) col-lg-9 @endif'>
            
        <!--<ul class='files file-{{$gift->id}} file-upload-{{$gift->id}} uploaded-files'>
                @foreach($gift->files as $file)
                    {{ View::make('affiliate/promote.partials.file')->with( compact('file') ) }}
                @endforeach
        </ul>-->
                <ul class='files file-{{$gift->id}} file-upload-{{$gift->id}} uploaded-files'>@foreach($gift->files as $file)
                    {{ View::make('affiliate/promote.partials.file')->with( compact('file') ) }}
                @endforeach</ul>
        <p class="label-progress-bar label-progress-bar-{{$gift->id}}"></p>
        <div class="progress"  style='display:none; margin-bottom: 10px;'>
            <div class="progress-bar progress-bar-striped active progress-bar-{{$gift->id}}" role="progressbar" 
                 data-label=".label-progress-bar-{{$gift->id}}" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                <span></span>
            </div>
        </div> 
        
    </div>
    </div>
</div>
<script>
    $('#gift-ui-holder').parent().parent('.modal-body').css('padding', '0px');
    $('#gift-ui-holder').parents('.modal-dialog').addClass('gift-ui-modal');

</script>
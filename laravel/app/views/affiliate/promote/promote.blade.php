<section>

    
    <div id='gifts' class='col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding gift-modal'>
        @foreach($course->gifts as $gift)
        {{ View::make('affiliate.promote.partials.gift')->with( compact('gift', 'course', 'tcode') ) }}
        @endforeach
    </div>
    <center>
        {{ Form::open([ 'action' => 'GiftsController@store', 'class' => 'ajax-form', 'data-callback '=> 'addGift' ]) }}
        	<div class="create-another-gift clear">
                <button type='submit' class=''> <i class='fa fa-plus'></i> {{ trans('affiliates.gifts.add-gift') }}</button>
                <input type='hidden' name='course_id' value='{{ $course->id }}' />
                <input type='hidden' name='tcode' value='{{ $tcode }}' />
                </div>
        {{ Form::close() }}
    </center>

</section>   

<script src="{{url('plugins/uploader/js/vendor/jquery.ui.widget.js')}}" type="text/javascript"></script>
<script src="{{url('plugins/uploader/js/jquery.iframe-transport.js')}}" type="text/javascript"></script>
<script src="{{url('plugins/uploader/js/jquery.fileupload.js')}}" type="text/javascript"></script>
<script>
function enableRTE(selector) {
    tinymce.remove(selector);
    tinymce.init({
        autosave_interval: "20s",
        autosave_restore_when_empty: true,
        selector: selector,
        save_onsavecallback: function () {
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

function addGift(json) {
    $('#gifts').prepend(json.html);
    console.log('adding this gift'+json.html);
    enableRTE(json.id);
    enableClipboard();
    enableFileUploader($(json.id).parent().parent().find('[type=file]'));
}

function giftFileUploaded(e, data) {
    var progressbar = $(e.target).attr('data-progress-bar');
    $(progressbar).find('span').html('');
    $(progressbar).css('width', 0 + '%');
    result = JSON.parse(data.result);
    if (result.status == 'error') {
        $(e.target).after("<p class='alert alert-danger ajax-error'>" + result.errors + '</p>');
        return false;
    }
    dest = $(e.target).attr('id');
    $('.' + dest).append(result.html);
//    $(progressbar).hide();
    $(progressbar).parent().hide();
    progressLabel = $(progressbar).attr('data-label');
    var $progressLabel = $(progressLabel);
    $progressLabel.html('');
    giftID = $(e.target).attr('data-gift-id');
    $('.gift-'+giftID).find('.dropzone').addClass('col-lg-3');
    $('.gift-'+giftID).find('.files-wrapper').addClass('col-lg-9');
    console.log('rearranged cols!!!!!!!!!!!!!   ');
    
}

$(function () {
    $('textarea').each(function () {
        enableRTE('#' + $(this).attr('id'));
    });
    $('[type=file]').each(function () {
        enableFileUploader($(this));
    });

});
</script>
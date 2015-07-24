<section>

    {{ Form::open([ 'action' => 'GiftsController@store', 'class' => 'ajax-form', 'data-callback '=> 'addGift' ]) }}
    <button type='submit' class='btn btn-primary'> {{ trans('courses/promote.add-gift') }}</button>
    <input type='hidden' name='course_id' value='{{ $course->id }}' />
    <input type='hidden' name='tcode' value='{{ $tcode }}' />
    {{ Form::close() }}
    <div id='gifts'>
        @foreach($course->gifts as $gift)
        {{ View::make('affiliate.promote.partials.gift')->with( compact('gift', 'course', 'tcode') ) }}
        @endforeach
    </div>

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
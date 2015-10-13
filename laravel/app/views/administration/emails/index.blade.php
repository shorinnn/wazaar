@extends('layouts.default')
@section('content')	
    
@if (Session::get('success'))
    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
@endif

<div class="container members-area  ajax-content">
    <div class="row">
    	<div class="col-md-12 well">
            <p><b>Email To Instructor After Sale</b></p>
            {{ Form::open(['action'=> 'EmailsController@update', 'method'=>'PUT', 'class'=>'ajax-form', 'data-callback'=>'formSaved' ] ) }}
                <input type='text' name='instructor-email-sale-subject' value='{{ $instructorSaleEmailSubject->value }}' />
                <textarea name='instructor-email-sale-content'>{{$instructorSaleEmail->value}}</textarea>
                <input type="hidden" name="fields[]" value="instructor-email-sale-content" />
                <input type="hidden" name="fields[]" value="instructor-email-sale-subject" />
                <p class="text-center"><button type="submit" class="btn btn-primary">Update</button></p>
            {{ Form::close() }}
            <small>
            Available tags:<br />
                @amount-paid@, @item-name@, @course-link@ (to get into classroom) @last-name@, @first-name@, @date@, @time@, @transaction-ID@
            </small>
        </div>
    </div>
    
    <div class="row">
    	<div class="col-md-12 well">
            <p><b>Email To Student After Sale</b></p>
            {{ Form::open(['action'=> 'EmailsController@update', 'method'=>'PUT', 'class'=>'ajax-form', 'data-callback'=>'formSaved' ] ) }}
                <input type='text' name='student-email-sale-subject' value='{{$studentSaleEmailSubject->value}}' />
                <textarea name='student-email-sale-content'>{{$studentSaleEmail->value}}</textarea>
                <input type="hidden" name="fields[]" value="student-email-sale-subject" />
                <input type="hidden" name="fields[]" value="student-email-sale-content" />
                <p class="text-center"><button type="submit" class="btn btn-primary">Update</button></p>
            {{ Form::close() }}
            <small>
            Available tags:<br />
                @amount-paid@, @item-name@, @course-link@ (to get into classroom) @last-name@, @first-name@, @date@, @time@, @transaction-ID@
            </small>
        </div>
    </div>
    
    <div class="row">
    	<div class="col-md-12 well">
            <p><b>Update Instructor On New Discussions</b></p>
            {{ Form::open(['action'=> 'EmailsController@update', 'method'=>'PUT', 'class'=>'ajax-form', 'data-callback'=>'formSaved' ] ) }}
                <input type='text' name='instructor-new-discussions-update-subject' value='{{$instructorNewDiscussionsUpdateEmailSubject->value}}' />
                <textarea name='instructor-new-discussions-update-content'>{{$instructorNewDiscussionsUpdateEmail->value}}</textarea>
                <input type="hidden" name="fields[]" value="instructor-new-discussions-update-content" />
                <input type="hidden" name="fields[]" value="instructor-new-discussions-update-subject" />
                <p class="text-center"><button type="submit" class="btn btn-primary">Update</button></p>
            {{ Form::close() }}
            <small>
            Available tags:<br />
                @number-new-discussions@, @number-of-courses@ (maybe 3 discussions over 2 courses for example), @dashboard-link@
            </small>
        </div>
    </div>
    
    <div class="row">
    	<div class="col-md-12 well">
            <p><b>Contact Form Wazaar Email</b></p>
            {{ Form::open(['action'=> 'EmailsController@update', 'method'=>'PUT', 'class'=>'ajax-form', 'data-callback'=>'formSaved' ] ) }}
                <input type='text' name='contact-form-submitted-wazaar-subject' value='{{$contactFormSubmittedWazaarSub->value}}' />
                <textarea name='contact-form-submitted-wazaar-content'>{{$contactFormSubmittedWazaar->value}}</textarea>
                <input type="hidden" name="fields[]" value='contact-form-submitted-wazaar-subject' />
                <input type="hidden" name="fields[]" value='contact-form-submitted-wazaar-content' />
                <p class="text-center"><button type="submit" class="btn btn-primary">Update</button></p>
            {{ Form::close() }}
            <small> 
                Available tags:<br />
                @date@, @role@, @question-type@, @name@, @email@, @subject@, @issue@
            </small>
        </div>
    </div>
    
    <div class="row">
    	<div class="col-md-12 well">
            <p><b>Contact Form Customer Email</b></p>
            {{ Form::open(['action'=> 'EmailsController@update', 'method'=>'PUT', 'class'=>'ajax-form', 'data-callback'=>'formSaved' ] ) }}
                <input type='text' name='contact-form-submitted-user-subject' value='{{$contactFormSubmittedUserSub->value}}' />
                <textarea name='contact-form-submitted-user-content'>{{$contactFormSubmittedUser->value}}</textarea>
                <input type="hidden" name="fields[]" value="contact-form-submitted-user-subject" />
                <input type="hidden" name="fields[]" value="contact-form-submitted-user-content" />
                <p class="text-center"><button type="submit" class="btn btn-primary">Update</button></p>
            {{ Form::close() }}
            <small> 
                Available tags:<br />
                @date@, @role@, @question-type@, @name@, @email@, @subject@, @issue@
            </small>
        </div>
    </div>
</div>

@stop


@section('extra_js')
<script>

    $(function(){
        tinymce.init({
            autosave_restore_when_empty: true,
            selector: 'textarea',
            plugins: [
                "advlist autolink autosave lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        });
    });
    

</script>
@stop
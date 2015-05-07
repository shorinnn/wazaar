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
    	<div class="col-md-12">
            <div class="table-wrapper table-responsive clear">
                <span class="table-title">
                     <div class="activate-dropdown">
                    </div>               
                </span>
        
                        {{ Form::open( ['action' => 'AdminEmailController@sendPublishers', 'class' => 'ajax-form', 'data-callback' => 'sent' ] ) }}
                             {{ trans('general.registered-before-date') }}
                             <input type="text" name='date' id='pkr' value='{{ date('d-m-Y') }}' required />
                         <input type='text' class='form-control' id='subject' name='subject' placeholder="{{ trans('general.email-subject') }}"
                                required />
                         <textarea id='content' name='content' style='width:100%'></textarea>
                         <p class="text-center">
                             <button type='submit' class="btn btn-primary">{{ trans('acl.send') }}</button>
                         </p>
                         
                         {{ Form::close() }}
         
            </div>
        </div>
    </div>
</div>

@stop


@section('extra_js')
<script>
    function sent(res, e){
        if(res.status=='success'){
            tinyMCE.activeEditor.setContent('');
            $('#subject').val('');
            $.bootstrapGrowl( "{{ trans('conversations/general.sent' ) }} ("+res.mails_sent+")",{align:'center', type:'success'} );
        }
        else{
            console.log('errors!!!');
            $.bootstrapGrowl( "{{ trans('crud/errors.error_occurred' ) }}",{align:'center', type:'danger'} );
        }
    }
    
    $(function(){
        $('#pkr').datepicker({format: "dd-mm-yyyy"});
        tinymce.init({
            autosave_restore_when_empty: true,
            selector: '#content',
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
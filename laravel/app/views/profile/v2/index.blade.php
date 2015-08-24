@extends('layouts.default')
@section('content')
    <div class="container-fluid new-dashboard top-section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <h1>{{trans('profile.yourAccount')}}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard dashboardTabs-header">
        <div class="container">
            <div class="row">
                <div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">{{trans('profile.tab')}}</a>
                        </li>
                        <li role="presentation">
                            <a href="#password" role="tab" id="password-tab" data-toggle="tab" aria-controls="password">{{trans('profile.tabPassword')}}</a>
                        </li>
                        <li role="presentation">
                            <a href="#bank-details" role="tab" id="bank-details-tab" data-toggle="tab" aria-controls="bank-details">{{trans('profile.tabBankDetails')}}</a>
                        </li>
                        <li role="presentation">
                            <a href="#other-info" role="tab" id="other-info-tab" data-toggle="tab" aria-controls="other-info">{{trans('profile.tabOtherInfo')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard student-account">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 pull-right margin-top-25">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="profile">
                            <div class="profile-input-rows">
                                <h4>{{trans('profile.pageTitle')}}</h4>
                                <div class="clearfix">
                                    <form id="form-profile">
                                        <div class="row no-margin">

                                            <div class="alert alert-error hidden" role="alert" id="errors-profile">
                                                <ul>

                                                </ul>
                                            </div>

                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.firstName')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                {{Form::text('first_name',$profile->first_name)}}
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.lastName')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                {{Form::text('last_name',$profile->last_name)}}
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.email')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                {{Form::text('email',$profile->email)}}
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.bio')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                {{Form::textarea('bio',$profile->bio)}}
                                            </div>
                                        </div>

                                        {{Form::hidden('type',$type)}}

                                        <div class="row no-margin" align="center">
                                            <button class="btn btn-primary" type="button" id="btn-update-profile">{{trans('general.update')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in" id="password">
                            <div class="profile-input-rows">
                                <h4>Change password</h4>
                                <div class="clearfix">
                                    <form>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Current password</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                <input type="password" placeholder="*********" />
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>New password</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                <input type="password" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Repeat password</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                <input type="password" placeholder="" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in" id="bank-details">
                            <div class="profile-input-rows">
                                <h4>Bank Details</h4>
                                <div class="clearfix">
                                    <form>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Bank Number</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Bank Code</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Branch Name</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Branch Code</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Account Type</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Account Number</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Beneficiary</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Other Info Tab --}}
                        <div role="tabpanel" class="tab-pane fade in" id="other-info">
                            <div class="profile-input-rows">
                                <h4>Other Information</h4>
                                <div class="clearfix">
                                    <form>
                                        <div class="row no-margin">
                                            <div class="col-md-4">
                                                <label>ZIP Code</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" placeholder="" />
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Prefecture</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Address 1</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Address 2</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div><div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Company Nae</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div><div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Telephone #</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                <input type="text" placeholder="" />
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- //Other Info Tab --}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <div class="sidebar">
                        <div class="profile-picture-holder">
                            <img src="{{@$profile->photo}}" alt="" class="img-responsive"/>
                        </div>
                        <div class="upload-picture-button text-center">
                            <label for="upload-new-photo" class="default-button large-button">
                                <span>{{ trans('general.upload_new_picture') }}</span>
                                <input type="file" hidden="" class='' id="upload-new-photo" name="profilePicture"/>
                            </label>
                        </div>
                        <a href="#" class="message-count message">
                            <i class="fa fa-comment-o"></i>
                            Messages
                            <span class="count">(2)</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('extra_js')
    <script src="{{url('plugins/uploader/js/jquery.fileupload.js')}}"></script>
    <script src="{{url('js/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            $('#btn-update-profile').on('click', function(){
                var $data = $('#form-profile').serialize();
                $('#errors-profile ul').html('');
                $.post('/profile/update-profile',$data, function ($response){
                    if ($response.success == 0){
                        for (var $errorKey in $response.errors){
                            $('#errors-profile ul').append('<li><i class="fa fa-exclamation"></i> '+ $response.errors[$errorKey] +'</li>');
                        }

                        $('#errors-profile').removeClass('hidden');
                    }
                },'json');
            });
        })
    </script>
@stop

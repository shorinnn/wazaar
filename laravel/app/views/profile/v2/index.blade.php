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
                                        <div class="row no-margin tooltipable"  title="{{trans('profile.form.name-tooltip')}}">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                               <label>{{trans('profile.form.name')}}</label>
                                            </div>
                                            
                                            <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                                                <label>{{trans('profile.form.firstName')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                                {{Form::text('first_name',$profile->first_name, ['class' => 'col-xs-3'])}}
                                            </div>
                                            <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                                                 <label>{{trans('profile.form.lastName')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-" >                                                
                                                {{Form::text('last_name',$profile->last_name, ['class' => 'col-xs-3'])}}
                                            </div>
                                            
                                        </div>
                                        <div class="row no-margin">

                                            <div class="alert alert-error hidden" role="alert" id="errors-profile">
                                                <ul>

                                                </ul>
                                            </div>

                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                               
                                            </div>
                                        </div>
                                        
                                        <div class="row no-margin tooltipable" title="{{trans('profile.form.corporation-name-tooltip')}}">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.corporation-name')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6 " >
                                                {{Form::text('corporation_name',$profile->corporation_name)}}
                                            </div>
                                        </div>
                                        <div class="row no-margin tooltipable" title="{{trans('profile.form.department-tooltip')}}">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.department')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6 " >
                                                {{Form::text('department',$profile->department)}}
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
                                            <button class="blue-button large-button" data-loading-text="{{trans('general.updating')}}" type="button" id="btn-update-profile">{{trans('general.update')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in" id="password">
                            <div class="profile-input-rows">
                                <h4>{{trans('profile.changePassword')}}</h4>
                                <div class="clearfix">
                                    <form action="{{url('profile/change-password')}}" method="post" id="form-change-password">

                                        <div class="alert alert-error hidden" role="alert" id="errors-change-password">
                                            <ul>

                                            </ul>
                                        </div>

                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.currentPassword')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                <input type="password" name="old_password"/>
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.newPassword')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                <input type="password" name="new_password" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.repeatPassword')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                <input type="password" name="new_password_confirmation" placeholder="" />
                                            </div>
                                        </div>
                                        {{Form::hidden('type',$type)}}
                                        <div class="row no-margin" align="center">
                                            <button class="btn btn-primary" data-loading-text="{{trans('general.updating')}}" type="button" id="btn-change-password">{{trans('general.update')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in" id="bank-details">
                            <div class="profile-input-rows">
                                <h4>{{trans('profile.tabBankDetails')}}</h4>
                                <div class="clearfix">
                                    {{Form::open(['url' => url('profile/update-bank-details'), 'id' => 'form-update-bank'])}}

                                    <div class="alert alert-error hidden" role="alert" id="errors-update-bank">
                                        <ul>

                                        </ul>
                                    </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.bankName')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                               {{Form::text('bank_name',$profile->bank_name)}}
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.bankCode')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                {{Form::text('bank_code',$profile->bank_code)}}
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.branchName')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                {{Form::text('branch_name',$profile->branch_name)}}
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.branchCode')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                {{Form::text('branch_code',$profile->branch_code)}}
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.accountType')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                {{Form::select('account_type',
                                            [
                                              '1' =>  trans('profile.form.accountTypes.ordinary'),
                                              '2' =>  trans('profile.form.accountTypes.checking'),
                                              '4' =>  trans('profile.form.accountTypes.savings'),
                                              '9' =>  trans('profile.form.accountTypes.others')
                                            ]
                                            , @$profile->account_type, ['class' => 'form-control'])}}
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.accountNumber')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                {{Form::text('account_number',$profile->account_number)}}
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.beneficiaryName')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
                                                {{Form::text('beneficiary_name',$profile->beneficiary_name)}}
                                            </div>
                                            {{Form::hidden('type',$type)}}
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-1 col-md-1 col-lg-1"></div>
                                            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                            {{trans('profile.form.bank-bottom-text')}}
                                            <br />
                                            <br />
                                            </div>
                                            <div class="col-sm-1 col-md-1 col-lg-1"></div>
                                        </div>
                                        <div class="row no-margin" align="center">
                                            <button class="btn btn-primary" data-loading-text="{{trans('general.updating')}}" type="button" id="btn-update-bank">{{trans('general.update')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Other Info Tab --}}
                        <div role="tabpanel" class="tab-pane fade in" id="other-info">
                            <div class="profile-input-rows">
                                <h4>{{trans('profile.otherInformation')}}</h4>
                                <div class="clearfix">
                                    {{Form::open(['url' => url('profile/update-other-info'), 'id' => 'form-update-info'])}}

                                    <div class="alert alert-error hidden" role="alert" id="errors-update-info">
                                        <ul>

                                        </ul>
                                    </div>
                                        <div class="row no-margin">
                                            <div class="col-md-4">
                                                <label>{{trans('profile.form.zip')}}</label>
                                            </div>
                                            <div class="col-md-4">
                                                {{Form::text('zip',$profile->zip)}}
                                            </div>

                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.prefecture')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                {{Form::text('prefecture',$profile->prefecture)}}
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.address1')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                {{Form::text('address1',$profile->address_1)}}
                                            </div>
                                        </div>
                                        <div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.address2')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                {{Form::text('address2',$profile->address_2)}}
                                            </div>
                                        </div><div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.company')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                {{Form::text('company',$profile->company)}}
                                            </div>
                                        </div><div class="row no-margin">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>{{trans('profile.form.telephone')}}</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-5">
                                                {{Form::text('telephone',$profile->telephone)}}
                                            </div>
                                        </div>

                                    <div class="row no-margin" align="center">
                                        <button class="btn btn-primary" data-loading-text="{{trans('general.updating')}}" type="button" id="btn-update-info">{{trans('general.update')}}</button>
                                    </div>
                                    {{Form::hidden('type',$type)}}
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- //Other Info Tab --}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <form action="{{url('profile/upload-profile-picture')}}" enctype="multipart/form-data" method="post">
                    <div class="sidebar">
                        <div class="profile-picture-holder">
                            
                            @if( isset($profile->photo) && trim($profile->photo) !='' )
                                <img src="{{@$profile->photo}}" alt="" id="img-profile-picture" class="img-responsive"/>
                            @else
                                <img src="http://s3-ap-northeast-1.amazonaws.com/wazaar/profile_pictures/avatar-placeholder.jpg" alt="" id="img-profile-picture" class="img-responsive"/>
                            @endif
                        </div>
                        <div class="upload-picture-button text-center">
                            <label for="upload-new-photo" class="default-button large-button">
                                <span>{{ trans('general.upload_new_picture') }}</span>
                                <input type="file" hidden="" class='' id="upload-new-photo" name="profilePicture"/>
                            </label>
                        </div>
<!--                        <a href="#" class="message-count message">
                            <i class="fa fa-comment-o"></i>
                            Messages
                            <span class="count">(2)</span>
                        </a>-->
                    </div>
                    </form>

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
                var $btn = $(this);
                $btn.button('loading');
                var $data = $('#form-profile').serialize();



                $('#errors-profile ul').html('');
                $.post('/profile/update-profile',$data, function ($response){
                    if ($response.success == 0){
                        for (var $errorKey in $response.errors){
                            $('#errors-profile ul').append('<li><i class="fa fa-exclamation"></i> '+ $response.errors[$errorKey] +'</li>');
                        }

                        $('#errors-profile').removeClass('hidden');
                    }
                    $btn.button('reset');
                },'json');
            });

            $('#btn-change-password').on('click', function(){
                var $data = $('#form-change-password').serialize();
                var $btn = $(this);
                $btn.button('loading');
                $('#errors-change-password ul').html('');
                $.post('/profile/change-password',$data, function ($response){
                    if ($response.success == 0){
                        for (var $errorKey in $response.errors){
                            $('#errors-change-password ul').append('<li><i class="fa fa-exclamation"></i> '+ $response.errors[$errorKey] +'</li>');
                        }

                        $('#errors-change-password').removeClass('hidden');

                    }
                    $btn.button('reset');
                },'json');
            });

            $('#btn-update-bank').on('click', function(){
                var $data = $('#form-update-bank').serialize();
                var $btn = $(this);
                $btn.button('loading');
                $('#errors-update-bank ul').html('');
                $.post('/profile/update-bank-details',$data, function ($response){
                    if ($response.success == 0){
                        for (var $errorKey in $response.errors){
                            $('#errors-update-bank ul').append('<li><i class="fa fa-exclamation"></i> '+ $response.errors[$errorKey] +'</li>');
                        }

                        $('#errors-update-bank').removeClass('hidden');

                    }

                    $btn.button('reset');
                },'json');
            });

            $('#btn-update-info').on('click', function(){
                var $data = $('#form-update-info').serialize();
                var $btn = $(this);
                $btn.button('loading');
                $('#errors-update-info ul').html('');
                $.post('/profile/update-other-info',$data, function ($response){
                    if ($response.success == 0){
                        for (var $errorKey in $response.errors){
                            $('#errors-update-info ul').append('<li><i class="fa fa-exclamation"></i> '+ $response.errors[$errorKey] +'</li>');
                        }

                        $('#errors-update-info').removeClass('hidden');

                    }

                    $btn.button('reset');
                },'json');
            });

            $('#upload-new-photo').fileupload()
                    .bind('fileuploadprogress', function ($e, $data){
                        var $progress = parseInt($data.loaded / $data.total * 100, 10);
                        console.log($progress);
                    })
                    .bind('fileuploaddone',function ($e,$data){
                        if ($data.result.success == 1){
                            $('#img-profile-picture').attr('src',$data.result.photo_url);
                        }
            });

            $('input[name=zip]').mask('999-9999');

        });
    </script>
@stop

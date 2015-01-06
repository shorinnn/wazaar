<div class="profile-wizard step2">
    {{Form::open(['url' => 'profile/store-new-profile'])}}
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-block">
            <h4 class="alert-heading">{{trans('profile.errorHeading')}}:</h4>
            <ul class="list-unstyled" id="error-lists">
                @foreach($errors as $error)
                    <li><i class="fa fa-exclamation-circle"></i> {{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h4>{{trans('profile.new.step2')}}</h4>
    <hr />

    <div class="form-group">
        {{Form::label('first_name', trans('profile.form.firstName'))}}
        {{Form::text('first_name', '', ['class' => 'form-control'])}}
    </div>
    <div class="form-group">
        {{Form::label('last_name', trans('profile.form.lastName'))}}
        {{Form::text('last_name', '', ['class' => 'form-control'])}}
    </div>
    <div class="form-group">
        {{Form::label('address_1', trans('profile.form.address1'))}}
        {{Form::text('address_1', '', ['class' => 'form-control'])}}
    </div>

    <div class="form-group">
        {{Form::label('address_2', trans('profile.form.address2'))}}
        {{Form::text('address_2', '', ['class' => 'form-control'])}}
    </div>

    <div class="pull-right">{{Form::submit(trans('crud/labels.next'),['class' => 'btn btn-success'])}}</div>
    <div class="clearfix"></div>

    {{Form::close()}}
</div>
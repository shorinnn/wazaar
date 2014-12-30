<div class="profile-wizard step2">
    {{Form::open(['url' => 'profile/store-new-profile'])}}
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-block">
            <h4 class="alert-heading">The following errors were found:</h4>
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
        {{Form::label('first_name', 'First Name')}}
        {{Form::text('first_name', '', ['class' => 'form-control', 'placeholder' => 'Enter First Name'])}}
    </div>
    <div class="form-group">
        {{Form::label('last_name', 'Last Name')}}
        {{Form::text('last_name', '', ['class' => 'form-control', 'placeholder' => 'Enter Last Name'])}}
    </div>
    <div class="form-group">
        {{Form::label('address_1', 'Address Line 1')}}
        {{Form::text('address_1', '', ['class' => 'form-control', 'placeholder' => 'Enter Address 1'])}}
    </div>

    <div class="form-group">
        {{Form::label('address_2', 'Address Line 2')}}
        {{Form::text('address_2', '', ['class' => 'form-control', 'placeholder' => 'Enter Address 2'])}}
    </div>

    <div class="pull-right">{{Form::submit('Next',['class' => 'btn btn-success'])}}</div>
    <div class="clearfix"></div>

    {{Form::close()}}
</div>
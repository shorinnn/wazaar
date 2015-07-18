<div class="form-group">
    {{Form::label('email', trans('profile.form.email'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::email('email',@$profile->email,['class' => 'form-control', 'placeholder' => 'Email'])}}
    </div>
</div>
<div class="form-group">
    {{Form::label('title', trans('profile.form.title'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('title',@$profile->title,['class' => 'form-control', 'placeholder' => 'Title'])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('first_name', trans('profile.form.firstName'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('first_name',@$profile->first_name,['class' => 'form-control', 'placeholder' => 'First Name'])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('last_name', trans('profile.form.lastName'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('last_name',@$profile->last_name,['class' => 'form-control', 'placeholder' => ''])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('address_1', trans('profile.form.address1'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('address_1',@$profile->address_1,['class' => 'form-control'])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('address_2', trans('profile.form.address2'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('address_2',@$profile->address_2,['class' => 'form-control'])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('city', trans('profile.form.city'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('city',@$profile->city,['class' => 'form-control'])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('zip', trans('profile.form.zip'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('zip',@$profile->zip,['class' => 'form-control'])}}
    </div>
</div>
<div class="form-group">
    {{Form::label('email', 'Email',['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::email('email',$profile->email,['class' => 'form-control', 'placeholder' => 'Email'])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('first_name', 'First Name',['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('first_name',$profile->first_name,['class' => 'form-control', 'placeholder' => 'First Name'])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('last_name', 'Last Name',['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('last_name',$profile->last_name,['class' => 'form-control', 'placeholder' => ''])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('address_1', 'Address 1',['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('address_1',$profile->address_1,['class' => 'form-control', 'placeholder' => ''])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('address_2', 'Address 2',['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('address_2',$profile->address_2,['class' => 'form-control', 'placeholder' => ''])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('city', 'City',['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('city',$profile->city,['class' => 'form-control', 'placeholder' => ''])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('zip', 'ZIP',['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('zip',$profile->zip,['class' => 'form-control', 'placeholder' => ''])}}
    </div>
</div>
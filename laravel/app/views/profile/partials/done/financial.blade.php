<div class="form-group">
    {{Form::label('bank_code', trans('profile.form.bank-code'),['class' => 'col-sm-3 control-label'] ) }}
    <div class="col-sm-9">
        {{Form::text('bank_code',@$profile->bank_code,['class' => 'form-control', 'maxlength' => 4 ] ) }}
    </div>
</div>
<div class="form-group">
    {{Form::label('bank_name', trans('profile.form.bank-name'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('bank_name',@$profile->bank_name,['class' => 'form-control', 'maxlength' => 15 ])}}
    </div>
</div>
<div class="form-group">
    {{Form::label('branch_code', trans('profile.form.branch-code'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('branch_code',@$profile->branch_code,['class' => 'form-control', 'maxlength' => 3 ])}}
    </div>
</div>
<div class="form-group">
    {{Form::label('branch_name', trans('profile.form.branch-name'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('branch_name',@$profile->branch_name,['class' => 'form-control', 'maxlength' => 15 ])}}
    </div>
</div>
<div class="form-group">
    {{Form::label('account_type', trans('profile.form.account-type'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::select('account_type',
                    [ 
                      '1' =>  trans('profile.form.account-types.ordinary'), 
                      '2' =>  trans('profile.form.account-types.checking'), 
                      '4' =>  trans('profile.form.account-types.savings'), 
                      '9' =>  trans('profile.form.account-types.others')
                    ]
                    , @$profile->account_type, ['class' => 'form-control'])}}
    </div>
</div>
<div class="form-group">
    {{Form::label('account_number', trans('profile.form.account-number'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('account_number',@$profile->account_number,['class' => 'form-control', 'maxlength' => 7 ])}}
    </div>
</div>
<div class="form-group">
    {{Form::label('beneficiary_name', trans('profile.form.beneficiary-name'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('beneficiary_name',@$profile->beneficiary_name,['class' => 'form-control', 'maxlength' => 30 ])}}
    </div>
</div>
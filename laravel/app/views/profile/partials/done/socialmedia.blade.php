<div class="form-group">
    {{Form::label('website', 'Webiste URL',['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('website',$profile->zip,['class' => 'form-control', 'placeholder' => ''])}}
    </div>
</div>
<div class="form-group">
    {{Form::label('google_plus', 'Google Plus',['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('google_plus',$profile->zip,['class' => 'form-control', 'placeholder' => 'Google+ URL'])}}
    </div>
</div>
<div class="form-group">
    {{Form::label('facebook', 'Facebook',['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('facebook',$profile->zip,['class' => 'form-control', 'placeholder' => 'Facebook URL'])}}                        </div>
</div>
<div class="form-group">
    {{Form::label('twitter', 'Twitter',['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('twitter',$profile->zip,['class' => 'form-control', 'placeholder' => 'Twitter URL'])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('linked_in', 'LinkedIn',['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('linked_in',$profile->zip,['class' => 'form-control', 'placeholder' => 'LinkedIn URL'])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('youtube', 'Youtube',['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('youtube',$profile->zip,['class' => 'form-control', 'placeholder' => 'Youtube URL'])}}
    </div>
</div>
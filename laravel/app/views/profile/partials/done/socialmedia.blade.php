<div class="form-group">
    {{Form::label('website', trans('profile.form.website'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('website',$profile->website,['class' => 'form-control'])}}
    </div>
</div>
<div class="form-group">
    {{Form::label('google_plus', trans('profile.form.google'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('google_plus',$profile->google_plus,['class' => 'form-control'])}}
    </div>
</div>
<div class="form-group">
    {{Form::label('facebook', trans('profile.form.facebook'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('facebook',$profile->facebook,['class' => 'form-control'])}}                        </div>
</div>
<div class="form-group">
    {{Form::label('twitter', trans('profile.form.twitter'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('twitter',$profile->twitter,['class' => 'form-control'])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('linked_in', trans('profile.form.linkedin'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('linked_in',$profile->linked_in,['class' => 'form-control'])}}
    </div>
</div>

<div class="form-group">
    {{Form::label('youtube', trans('profile.form.youtube'),['class' => 'col-sm-3 control-label'])}}
    <div class="col-sm-9">
        {{Form::text('youtube',$profile->youtube,['class' => 'form-control'])}}
    </div>
</div>
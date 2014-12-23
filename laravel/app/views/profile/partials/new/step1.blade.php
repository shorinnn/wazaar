<div class="profile-wizard step1">
    {{Form::open(['url' => 'profile/upload-profile-picture',  'files' => true])}}
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
        <h4>{{trans('profile.new.step1')}}</h4>
        <hr />

        <div class="form-group">
            {{Form::file('profilePicture')}}
            <span class="label label-warning">{{trans('profile.allowedPictureFormat')}}</span>
        </div>

        <div class="pull-right">{{Form::submit('Next',['class' => 'btn btn-success'])}}</div>
        <div class="clearfix"></div>


    {{Form::close()}}
</div>
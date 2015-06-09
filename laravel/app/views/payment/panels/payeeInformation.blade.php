<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Payee Information</h3>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label for="">Email</label>
            <div class="input-group">
                {{Form::email('email',$student->profile->email,['class' => 'form-control'])}}
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            </div>
        </div>

        <div class="form-group">
            <label for="">First Name</label>
            <div class="input-group">
                {{Form::text('firstName',$student->profile->first_name,['class' => 'form-control'])}}
                <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
            </div>
        </div>

        <div class="form-group">
           <label for="">Last Name</label>
              <div class="input-group">
                 {{Form::text('lastName',$student->profile->last_name,['class' => 'form-control'])}}
                 <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
              </div>
        </div>

        <div class="form-group">
           <label for="">City</label>
              <div class="input-group">
                 {{Form::text('city',$student->profile->city,['class' => 'form-control'])}}
                 <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
              </div>
        </div>

        <div class="form-group">
           <label for="">ZIP Code</label>
              <div class="input-group">
                 {{Form::text('zip',$student->profile->zip,['class' => 'form-control'])}}
                 <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
              </div>
        </div>
    </div>

</div>
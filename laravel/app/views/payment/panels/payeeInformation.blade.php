<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Payee Information</h3>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label for="">Email</label>
            <div class="input-group">
                {{Form::email('email',$payee->profile->email,['class' => 'form-control'])}}
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            </div>
        </div>

        <div class="form-group">
            <label for="">First Name</label>
            <div class="input-group">
                {{Form::text('firstName',$payee->profile->first_name,['class' => 'form-control'])}}
                <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
            </div>
        </div>

        <div class="form-group">
           <label for="">Last Name</label>
              <div class="input-group">
                 {{Form::text('lastName',$payee->profile->last_name,['class' => 'form-control'])}}
                 <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
              </div>
        </div>

        <div class="form-group">
           <label for="">City</label>
              <div class="input-group">
                 {{Form::text('city',$payee->profile->city,['class' => 'form-control'])}}
                 <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
              </div>
        </div>

        <div class="form-group">
           <label for="">ZIP Code</label>
              <div class="input-group">
                 {{Form::text('zip',$payee->profile->zip,['class' => 'form-control'])}}
                 <span class="input-group-addon"><span class="glyphicon glyphicon-align-justify"></span></span>
              </div>
        </div>
    </div>

</div>
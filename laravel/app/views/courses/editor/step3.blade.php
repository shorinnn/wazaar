    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 left-content">
    <div class="approval-box">
            <h4 class="not-approved">Not approved!</h4>
        <p class="regular-paragraph">
        Wazaar must review and approve your course before you can publish it.
        </p>
    </div>
    <div class="row editor-settings-layout margin-bottom-30">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h4 class="text-right">Enable Ask Coach</h4>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="toggle-switch">
                    <button name="yes" class="toggle-button">Yes</button>
                <button name="no" class="toggle-button">No</button>
            </div>
        </div>
    </div>
    <div class="row editor-settings-layout margin-bottom-30">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h4 class="text-right">Payment type</h4>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <select>
                    <option>One time</option>
                <option></option>
            </select>
            <span class="regular-paragraph clue-text">How users will pay for a course. </span>
        </div>
    </div>
    <div class="row editor-settings-layout margin-bottom-30">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h4 class="text-right">Difficulty</h4>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="toggle-switch">
                    <button name="beginner" class="toggle-button">Beginner</button>
                <button name="intermediate" class="toggle-button">Intermediate</button>
                <button name="advanced" class="toggle-button">Advanced</button>
            </div>
        </div>
    </div>
    <div class="row editor-settings-layout margin-bottom-30">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h4 class="text-right">Discount</h4>
        </div>
            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
            <input type="text">
        </div>
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
            <select>
            </select>
        </div>
    </div>
    <div class="row editor-settings-layout margin-bottom-30">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h4 class="text-right">Price</h4>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="value-unit">
                    <input type="text" name="amount">
                <span>¥</span>
            </div>
        </div>
    </div>
    <div class="row editor-settings-layout margin-bottom-30">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h4 class="text-right">Affiliate percentage</h4>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="value-unit">
                    <input type="text" name="amount">
                <span>%</span>
            </div>
        </div>
    </div>
    <div class="row editor-settings-layout margin-bottom-30">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h4 class="text-right">{{ trans('courses/general.sale_starts_on') }}</h4>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="calender">
                  <div class="clear clearfix input-group date">
                      {{ Form::text('sale_starts_on', null, ['class'=>'form-control sales-end-calender datetimepicker']) }}
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
            </div>
        </div>
    </div>
    <div class="row editor-settings-layout margin-bottom-30">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <h4 class="text-right">{{ trans('courses/general.sale_ends_on') }}</h4>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="calender">
                <div class="clear clearfix input-group date">
                    {{ Form::text('sale_ends_on', null, ['class'=>'form-control sales-end-calender datetimepicker']) }}
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 right-content">
    <h2>Course summary</h2>
    <div class="row category-row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <p class="regular-paragraph">Category</p>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <p class="regular-paragraph semibold-text">IT & WEB</p>
                </div>
            </div>
            <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <p class="regular-paragraph">Sub-category</p>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <p class="regular-paragraph semibold-text">Websites</p>
                </div>
            </div>
            <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <p class="regular-paragraph">Price: </p>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <p class="regular-paragraph semibold-text">7,200</p>
                </div>
            </div>
            <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <p class="regular-paragraph">Modules: </p>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <p class="regular-paragraph semibold-text">4</p>
                </div>
            </div>
            <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <p class="regular-paragraph">Total lessons: </p>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <p class="regular-paragraph semibold-text">26</p>
                </div>
            </div>
        </div>
        <a href="#" class="edit-button">Edit</a>
    </div>
                    <div class="row margin-top-40">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4>Description:</h4>
            <p class="regular-paragraph">
            Did you know that if you upload a test video you are over 3 times as likely to have your course published and 
            featured on Udemy? Upload a short, ~1 ...minute long video and upload it to the test video tool by following 
            </p>
        </div>
    </div>
                    <div class="row margin-top-40">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4>What is this for:</h4>
            <ul>
                    <li>Did you know that </li>
                    <li>If you upload a test video </li>
                    <li>You are over 3 times as likely to have your course published and featured on </li>
            </ul>
        </div>
    </div>
                    <div class="row margin-top-40">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4>Requirements:</h4>
            <ul>
                    <li>Did you know that </li>
                    <li>If you upload a test video </li>
                    <li>You are over 3 times as likely to have your course published and featured on </li>
            </ul>
        </div>
    </div>
                    <div class="row margin-top-40">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4>At the end of course you will be able:</h4>
            <ul>
                    <li>Did you know that </li>
                    <li>If you upload a test video </li>
                    <li>You are over 3 times as likely to have your course published and featured on </li>
            </ul>
        </div>
    </div>
    <div class="row next-step-button">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <button class="blue-button extra-large-button">SUBMIT FOR APPROVAL</button>
        </div>
    </div>
</div>

<script src="{{url('js/moment.js')}}" type="text/javascript"></script>
<script src="{{url('js/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
<script type="text/javascript"> 
    $('.datetimepicker').datetimepicker( { 
        sideBySide:true,
        extraFormats: ['YYYY-MM-DD hh:mm:s']
    } );
</script>

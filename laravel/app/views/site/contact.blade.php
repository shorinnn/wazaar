@extends('layouts.default')
@section('content')
<section class="container-fluid contact-us header">
	<div class="container">
    	<h2>Contact Us</h2>
    </div>
</section>

<section class="container-fluid contact-us main">
    <form method='post' data-parsley-validate action='{{ url('contact-confirmation') }}'>
	<div class="container">
                <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <label>Type of question</label>
                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                        <div>
                            <input type='radio' name='user' value='Student' id='user-1' required /> Student
                            <input type='radio' name='user' value='Instructor' id='user-2' /> Instructor
                            <input type='radio' name='user' value='Affiliate' id='user-3' /> Affiliate
                            <input type='radio' name='user' value='Other' id='user-4' /> Other
                        </div>
                    </div>
                </div>
                <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <label>Type of issue</label>
                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                        <select name='question_type' required data-parsley-error-message="この値は必須です。" data-parsley-minlength="6">
                                <option value=''>Question</option>
                                <option value="ご質問内容をお選びください。">ご質問内容をお選びください。</option>
                                <option value="Wazaarの使い方">Wazaarの使い方</option>
                                <option value="会員登録">会員登録</option>
                                <option value="講座受講">講座受講</option>
                                <option value="動画配信">動画配信</option>
                                <option value="取材のご依頼">取材のご依頼</option>
                                <option value="その他">その他</option>
                                <option value="Wazaarへのリクエストなど">Wazaarへのリクエストなど</option>
                        </select>
                        <em class="block tip">Description about types, which to choose.</em>
                    </div>
                </div>
                    <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <label>Your name</label>
                </div>
                <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                    <input type="text" name='name' placeholder="Enter name..." required />
                </div>
            </div>
                    <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <label>Email</label>

                </div>
                <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                    <input type="email" name='email' placeholder="Enter email..." required data-parsley-trigger="change" />

                </div>
            </div>
                    <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <label>Subject</label>

                </div>
                <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                    <input type="text" name='subject' placeholder="Enter subject..." required />

                </div>
            </div>
                    <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <label>Message</label>

                </div>
                <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                    <textarea name='message' placeholder="Enter message..." required></textarea>
                </div>
            </div>
                    <div class="row input-row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

                </div>
                <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                    <button type='submit' class="large-button blue-button send">Send</button>
                </div>
            </div>
        </div>
    </form>
</section>
@stop
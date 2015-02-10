<?php 
$I = new FunctionalTester($scenario);

$I->wantTo('upload a lesson video');

Auth::attempt(['username' => 'instructor', 'password' => 'pass']);
$user = Auth::user();
$course = Course::where('name','App Development')->first();
$I->amLoggedAs($user);

$I->amOnPage('/courses/'.$course->slug.'/curriculum');

$I->click('Add Lesson');
$I->click('.edit-lesson');
$I->see('Video');
$I->click('.a-add-video');
$I->sendAjaxGetRequest('/lessons/blocks/0/video');
$I->see('Upload');
<?php

Event::listen('auth.login', function($event)
{
    $student = Student::find(Auth::user()->id);
    $student->restoreReferrals();
    return false;
});
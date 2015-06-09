<?php

class AnalyticsTest extends TestCase
{
    public function testRawReturnsCollection()
    {
        $analyticsHelper = new AnalyticsHelper(true);
        $dailyCourses = $analyticsHelper->dailyTopCourses('');

        $this->assertTrue(is_array($dailyCourses));
    }
}
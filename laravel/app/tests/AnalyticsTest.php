<?php

class AnalyticsTest extends TestCase
{
    public function testRawReturnsCollection()
    {
        $analyticsHelper = new AnalyticsHelper;
        $dailyCourses = $analyticsHelper->dailyTopCourses();

        $this->assertTrue(is_array($dailyCourses));
    }
}
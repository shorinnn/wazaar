<?php
return [
    'currency_decimals'    => 0,
    'html_row_classes'     => [ 'first', 'second', 'third', 'fourth', 'fifth' ],
    'course_preview_image' => [ 'width' => '312', 'height' => '176', 'hi_res_width' => '624', 'hi_res_height' => '252', 
                                'allowed_types' => ['.jpg', '.png', '.gif', '.bmp'] ],
    'course_banner_image'  => [ 'width' => '656', 'height' => '266', 'allowed_types' => ['.jpg', '.png', '.gif', '.bmp'] ],
    'course_is_new'        => [ 'maximum_students' => 20, 'maximum_months' => 6 ],
    'tracker_url'          => 'http://wazaar.dev/action_tracker',
    'maximum_lesson_files' => 10,
    'course_attachments' => ['.jpg', '.png', '.gif', '.bmp', '.txt', '.pdf', '.zip'],
    'use_id_for_slug' => true,
    'short_desc_max_chars' => 100,
    'earnings' => ['instructor_percentage' => 70, 'site_percentage' => 30, 'ltc_percentage' => 5, 'agency_percentage' => 5,
                   'second_tier_percentage' => 2, 'second_tier_instructor_percentage' => 2 ],
    'cashout' => [ 'fee' => 15, 'threshold' => 50, 'start_date' => '01-01-2015' ]
];
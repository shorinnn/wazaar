<?php
return [
    'currency_decimals'    => 0,
    'html_row_classes'     => [ 'first', 'second', 'third', 'fourth', 'fifth' ],
    'course_preview_image' => [ 'width' => '360', 'height' => '203', 'hi_res_width' => '720', 'hi_res_height' => '406', 
                                'desc_width' => '1024', 'desc_height' => '576', 'desc_hi_res_width' => '2048', 'desc_hi_res_height' => '1152',
                                'allowed_types' => ['.jpg', '.png', '.gif', '.bmp'] ],
    'course_banner_image'  => [ 'width' => '656', 'height' => '266', 'allowed_types' => ['.jpg', '.png', '.gif', '.bmp'] ],
    'course_is_new'        => [ 'maximum_students' => 3, 'maximum_months' => 6 ],
    'tracker_url'          => 'http://wazaar.jp/action_tracker',
    'maximum_lesson_files' => 10,
    'course_attachments' => ['.jpg', '.png', '.gif', '.bmp', '.txt', '.pdf', '.zip', '.doc', '.docx'],
    'use_id_for_slug' => true,
    'short_desc_max_chars' => 41,
    'earnings' => ['instructor_percentage' => 68, 'site_percentage' => 30, 'ltc_percentage' => [3, 8], 'second_tier_percentage' => 2, 
                   'second_tier_instructor_percentage' => 2, 'self_promotion_instructor_percentage' => 80, 'self_promotion_site_percentage' => 20 ],
    'cashout' => [ 'fee' => 15, 'threshold' => 50, 'start_date' => '01-01-2015' ],
    'first_name_first' => false,
    'vimeo' => ['client_id' => '9b523659aa38c4861c1d6675e431da7905941c8a', 'access_token' => '8116968eb0069207a0cda07b52477840',
            'client_secret' => 'B+IJ8cvhOyZgq0XzR+KZS0M+uNgcNm41oje+KcBThjhmcpBUQeYQv8s4z6xiMhDEB1a8yXohuoc79lBPVDLaagwyi5oer6R5h5WTVCUFHuMSVFFihUUqkMLJmpc8CgE1'],
    'cache-expiry' => [
        'course-desc-top-details' => 20,
        'course-desc-bottom-details' => 30,
        'student-dash-enrolled-image' => 30,
        'student-dash-lesson-count' => 30,
        'student-dash-first-lesson' => 30,
        'student-dash-completed-course' => 30,
        'student-dash-wishlist-course' => 30,
        'course-box' => 30,
    ],
    'course-desc-lesson-chars' => 25,
    'cloudsearch-document-endpoint' => 'doc-wazaar-isiopucantw3jmfljy5ayyfrda.ap-northeast-1.cloudsearch.amazonaws.com',
    'cloudsearch-search-endpoint' => 'search-wazaar-isiopucantw3jmfljy5ayyfrda.ap-northeast-1.cloudsearch.amazonaws.com',
];
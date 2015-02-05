<?php
return [
    'currency_decimals'    => 0,
    'html_row_classes'     => [ 'first', 'second', 'third', 'fourth', 'fifth' ],
    'course_preview_image' => [ 'width' => '312', 'height' => '176', 'allowed_types' => ['.jpg', '.png', '.gif', '.bmp'] ],
    'course_banner_image'  => [ 'width' => '250', 'height' => '150', 'allowed_types' => ['.jpg', '.png', '.gif', '.bmp'] ],
    'course_is_new'        => [ 'maximum_students' => 20, 'maximum_months' => 6 ],
    'tracker_url'          => 'http://wazaar.dev/action_tracker',
    'maximum_lesson_files' => 10,
    'course_attachments' => ['.jpg', '.png', '.gif', '.bmp', '.txt', '.pdf'],
    'use_id_for_slug' => true,
    'short_desc_max_chars' => 100
];
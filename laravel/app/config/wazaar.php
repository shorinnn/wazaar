<?php

return [
    'AWS_VIDEO_PRESETS' =>
        [
            /*'1351620000001-100020' => 'iPhone 4s and above, iPad 3G and above, iPad mini, Samsung Galaxy S2/S3/Tab 2', //mobile
            '1351620000001-000040' => 'Generic 360p 16:9 Resolution' , //tablet
            '1351620000001-100070' => 'Facebook, SmugMug, Vimeo, YouTube' //desktop*/
            //'1421660966371-o9l23s' => 'Custom Preset for Mobile Devices',
            '1436779339512-wtkz9d' => 'Custom Preset for Mobile Devices',
            //'1421661161826-cx6nmz' => 'Custom Preset for Desktop Devices'
            '1436779736434-6m5wzw' => 'Custom Preset for Desktop Devices'
        ],
    'AWS_WEB_DOMAIN' => 'd2t29bdxhtuuvy.cloudfront.net',
    'S3_PROFILES_BUCKET' => 'profile_pictures',
    'TAX' => '.08',
    'API_URL' => 'http://cocorium.com/api/',
    'PAGINATION' => 10,
    'AWS_REGION_DOMAIN' => '//s3-ap-northeast-1.amazonaws.com',
    'AWS_VIDEO_INPUT_BUCKET' => 'videosinput-tokyo',
    'AWS_VIDEO_OUTPUT_BUCKET' => 'videosoutput-tokyo',
    'AWS_PIPELINEID' =>   '1436778785974-dhm3iq',
    'DELIVERED_ENDPOINT' => getenv('DELIVERED_ENDPOINT'),
    'DELIVERED_API_KEY' => getenv('DELIVERED_API_KEY'),
    'DELIVERED_TOKEN' =>  getenv('DELIVERED_TOKEN')

    ];
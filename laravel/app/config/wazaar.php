<?php

return [
    'AWS_VIDEO_PRESETS'       =>
        [
            '1436790010046-k9rw9e' => 'Custom Preset for Desktop Devices',
            '1436779339512-wtkz9d' => 'Custom Preset for Mobile Devices',
            '1436790034239-byka2c' => 'Low Resolution'
        ],
    'AWS_WEB_DOMAIN'          => 'd2fgya2kk46gnk.cloudfront.net',
    'CLOUDFRONT_KEY_PAIR'     => 'APKAISTG64EY2VTVP5RQ',
    'S3_PROFILES_BUCKET'      => 'profile_pictures',
    'TAX'                     => '.08',
    'API_URL'                 => 'http://cocorium.com/api/',
    'PAGINATION'              => 10,
    'AWS_REGION_DOMAIN'       => '//s3-ap-southeast-1.amazonaws.com',
    'AWS_VIDEO_INPUT_BUCKET'  => 'wazaar-demo-input',
    'AWS_VIDEO_OUTPUT_BUCKET' => 'wazaar-demo-output',
    'AWS_PIPELINEID'          => '1467290820907-m9rb45',
    'DELIVERED_ENDPOINT'      => getenv('DELIVERED_ENDPOINT'),
    'DELIVERED_API_KEY'       => getenv('DELIVERED_API_KEY'),
    'DELIVERED_TOKEN'         => getenv('DELIVERED_TOKEN')
    /*
        --------DEMO CREDS---------
        'AWS_WEB_DOMAIN' => 'd2fgya2kk46gnk.cloudfront.net',
      'CLOUDFRONT_KEY_PAIR' => 'APKAISTG64EY2VTVP5RQ',
      'AWS_REGION_DOMAIN' => '//s3-ap-southeast-1.amazonaws.com',
      'AWS_VIDEO_INPUT_BUCKET' => 'wazaar-demo-input',
      'AWS_VIDEO_OUTPUT_BUCKET' => 'wazaar-demo-output',
      'AWS_PIPELINEID' =>   '1467290820907-m9rb45',
                             */

];
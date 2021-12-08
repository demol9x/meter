<?php
$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'orrrLDh9HrOEH2y8f97Yj71NBUiDJJp7',
        ],
        // 'urlManagerFrontEnd' => [
        //     'class' => 'yii\web\urlManager',
        //     'baseUrl' => '/gcaeco',
        //     'enablePrettyUrl' => true,
        //     'showScriptName' => false,
        // ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}
return $config;
return [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'orrrLDh9HrOEH2y8f97Yj71NBUiDJJp7',
        ],
        // 'urlManagerFrontEnd' => [
        //     'class' => 'yii\web\urlManager',
        //     'baseUrl' => '/gcaeco',
        //     'enablePrettyUrl' => true,
        //     'showScriptName' => false,
        // ],
    ],
];

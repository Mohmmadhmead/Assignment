<?php

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'hN34G1SRTOH9u8drVZZdHGdgxnoIb1Xt',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
  

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;

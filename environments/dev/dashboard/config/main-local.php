<?php

$config = [
    'defaultRoute' => 'car-listing/index',
    'components' => [
        'queue' => [
            'class' => \yii\queue\db\Queue::class, // or \yii\queue\file\Queue if you're using file-based
            'db' => 'db', // Database connection
            'tableName' => '{{%queue}}', // Table name for jobs if using DB-based queue
            'channel' => 'default', // Queue channel
            'as log' => \yii\queue\LogBehavior::class,
            'mutex' => \yii\mutex\MysqlMutex::class, // Specify MysqlMutex for the queue
        ],
        'mutex' => [
            'class' => \yii\mutex\MysqlMutex::class, // Configure mutex globally for Yii2 components
            'db' => 'db', // Connection to the database
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
    ];
}

return $config;

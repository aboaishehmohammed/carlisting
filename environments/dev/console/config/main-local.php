<?php

return [
    'bootstrap' => ['gii', 'log', 'queue'],
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
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
        'log' => [
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
];

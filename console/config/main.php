<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => \yii\console\controllers\FixtureController::class,
            'namespace' => 'common\fixtures',
          ],
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
    'params' => $params,
];

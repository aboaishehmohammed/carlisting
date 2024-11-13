<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'dashboard\controllers',
    'defaultRoute' => 'car-listing/index',
    'bootstrap' => ['log'],
    'name' => 'Dashboard',
    'modules' => [],
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
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];

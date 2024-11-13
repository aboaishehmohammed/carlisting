<?php

namespace console\controllers;

use common\models\User;
use yii\console\Controller;
use common\services\UserService;
use common\repositories\UserRepository;

class AdminController extends Controller
{
    private $userService;

    public function __construct($id, $module, $config = [])
    {
        $userRepository = new UserRepository();
        $this->userService = new UserService($userRepository);
        parent::__construct($id, $module, $config);
    }

    /**
     * Creates a new admin user.
     * Run command: php yii admin/create <username> <password>
     *
     * @param string $username The username of the new admin
     * @param string $password The password of the new admin
     */
    public function actionCreate($username, $password)
    {
        $result = $this->userService->createUser($username, $password, User::ROLE_ADMIN);

        if ($result === true) {
            echo "Admin user created successfully.\n";
        } else {
            echo "Error creating admin user: $result\n";
        }
    }
}

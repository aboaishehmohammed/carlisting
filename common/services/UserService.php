<?php

namespace common\services;

use common\repositories\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Create a new admin user.
     *
     * @param string $username
     * @param string $password
     * @return bool|string Returns true if created, or an error message if failed
     */
    public function createUser($username, $password, $type = 'buyer')
    {
        if ($this->userRepository->findByUsername($username)) {
            return "Username already exists.";
        }

        $user = $this->userRepository->createUser($username, $password, $type);

        return $user ? true : "Error saving the user.";
    }
}

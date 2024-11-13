<?php

namespace common\repositories;

use common\models\User;

class UserRepository
{
    /**
     * Find a user by username.
     *
     * @param string $username
     * @return User|null
     */
    public function findByUsername($username)
    {
        return User::findOne(['username' => $username]);
    }

    /**
     * Create and save a new user.
     *
     * @param string $username
     * @param string $password
     * @param string $role
     * @return User|null Returns the User object if saved successfully, or null if it failed
     */
    public function createUser($username, $password, $role)
    {
        $user = new User();
        $user->username = $username;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->role = $role;
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        return $user->save() ? $user : null;
    }
}

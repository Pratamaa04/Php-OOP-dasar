<?php

require_once 'models/model_user.php';
require_once 'models/model_role.php';

class controllerUser
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new modelUser();
    }

    public function addUser($uname, $pass, $role)
    {
        // $role = modelRole->getRoleByName($role_name);
        $this->userModel->addUser($uname, $pass, $role);
        htmlspecialchars('location: index.php?modul=user');
    }

    public function getUser()
    {
        return $this->userModel->getUser();
    }

    public function getUserById($userId)
    {
        $this->userModel->getUserById($userId);
    }

    public function deleteUser($idUser)
    {
        $this->userModel->deleteUser($idUser);
        htmlspecialchars('location: index.php?modul=user');
    }

    public function updateUser($idUser, $username, $password, $role)
    {
        $this->userModel->updateUser($idUser, $username, $password, $role);
        htmlspecialchars('location: index.php?modul=user');
    }
}

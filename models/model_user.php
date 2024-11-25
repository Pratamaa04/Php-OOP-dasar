<?php

require_once "nodes/node_user.php";
require_once "nodes/node_role.php";

class modelUser
{

    private $users = [];

    private $nextId = 1;

    public function __construct()
    {
        if (isset($_SESSION['users'])) {
            $this->users = unserialize($_SESSION['users']);
            $this->nextId = count($this->users) + 1;
        } else {
            $this->initializeDefaultUser();
        }
    }
    public function addUser($uname, $pass, $role)
    {
        $user = new \User($this->nextId++, $uname, $pass, $role);
        $this->users[] = $user;
        $this->saveToSession();
    }

    public function saveToSession()
    {
        $_SESSION['users'] = serialize($this->users);
    }

    public function getUser()
    {
        return $this->users;
    }

    public function initializeDefaultUser()
    {
        $obj_role1 = new \role(1, "admin", "administrator", 1);
        $obj_role2 = new \role(2, "kasir", "kasir", 1);
        $this->addUser("pratamaa@gmail.com", "123", $obj_role1);
        $this->addUser("ichiji@gmail.com", "123", $obj_role2);
        $this->addUser("dicky@gmail.com", "123", $obj_role1);
    }

    public function getUserById($userId)
    {
        foreach ($this->users as $user) {
            if ($user->user_id == $userId) {
                return $user;
            }
        }
        return null;
    }

    public function deleteUser($idUser)
    {
        if ($idUser != null) {
            $key = array_search($idUser, $this->users);
            unset($this->users[$key]);
            $this->users = array_values($this->users);
            $this->saveToSession();
            return true;
        }
        return false;
    }

    public function updateUser($idUser, $username, $password, $role)
    {
        $userlokal = $this->getUserById($idUser);
        if ($this->getUserById($idUser) != null) {
            $userlokal->username = $username;
            $userlokal->password = $password;
            $userlokal->role = $role;
            $this->saveToSession();
            return true;
        }
        return false;
    }
}

// session_start();
// $obj_user = new modelUser();
// $users = $obj_user->getUser();
// foreach ($users as $user) {
//     echo "username : " . $user->username . "<br>";
//     echo "password : " . $user->password . "<br>";
//     echo "role name : " . $user->role->role_name . "<br>";
// }

// $userlokal = $obj_user->getUserById(1);
// Delete
// $obj_user->deleteUser($userlokal);
// foreach ($users as $user) {
//     echo "Username: ".$user->username."<br/>";
//     echo "Password: ".$user->password."<br/>";
//     echo "Role Name: ".$user->role->role_name."<br/>";
// }

// echo "====================<br>";
// echo "testing search user by id<br> ";

// $userlokal = $obj_user->getUserById(1);
// $obj_role2 = new \role(2, "kasir", "kasir", 1);
// $obj_user->updateUser(1, "dickypratama@gmail.com", "123", $obj_role2);
// foreach ($users as $user) {
//     echo "username : " . $user->username . "<br>";
//     echo "password : " . $user->password . "<br>";
//     echo "role name : " . $user->role->role_name . "<br>";
// }

<?php

require_once 'models/model_role.php';

class controllerRole
{

    private $roleModel;

    public function __construct()
    {
        $this->roleModel = new modelRole();
    }

    public function listRoles()
    {
        $roles = $this->roleModel->getAllRoles();
        include 'views/role_list.php';
    }

    public function addRole($role_name, $role_description, $role_status)
    {
        $this->roleModel->addRole($role_name, $role_description, $role_status);
        header('location: index.php?modul=role');
    }

    public function editById($id)
    {
        $role = $this->roleModel->getRoleById($id);
        include 'views/role_edit.php';
    }

    public function updateRole($id, $name, $desc, $status)
    {
        $this->roleModel->updateRole($id, $name, $desc, $status);
        header('location: index.php?modul=role');
    }

    public function deleteRole($id)
    {
        $this->roleModel->deleteRole($id);
    }

    public function getByRoleName($role_name)
    {
        $this->roleModel->getRoleByName($role_name);
    }
}

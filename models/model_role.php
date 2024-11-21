<?php

require_once 'nodes/node_role.php';

class modelRole
{
    public $roles = [];
    private $nextId = 1;

    public function __construct()
    {
        if (isset($_SESSION['roles'])) {
            $this->roles = unserialize($_SESSION['roles']);
            $this->nextId = count($this->roles) + 1;
        } else {
            $this->initializeDefaultRole();
        }
    }
    public function addRole($role_name, $role_description, $role_status)
    {
        $peran = new \Role($this->nextId++, $role_name, $role_description, $role_status);
        $this->roles[] = $peran;
        $this->saveToSession();
    }
    public function initializeDefaultRole()
    {
        $this->addRole("Admin", "Administrasi", 1);
        $this->addRole("Cutomer", "Customer/member", 0);
        $this->addRole("Kasir", "Bayar", 1);
    }

    private function saveToSession()
    {
        $_SESSION['roles'] = serialize($this->roles);
    }

    public function getAllRoles()
    {
        return $this->roles;
    }

    public function getRoleById($role_id)
    {
        foreach ($this->roles as $role) {
            if ($role->role_id == $role_id) {
                return $role;
            }
        }
        return null;
    }

    public function updateRole($role_id, $role_name, $role_description, $role_status)
    {
        foreach ($this->roles as $role) {
            if ($role->role_id == $role_id) {
                $role->role_name = $role_name;
                $role->role_description = $role_description;
                $role->role_status = $role_status;
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    public function deleteRole($role_id)
    {
        foreach ($this->roles as $key => $role) {
            if ($role->role_id == $role_id) {
                unset($this->roles[$key]); // Hapus role dari array
                $this->roles = array_values($this->roles); // Reset indeks array
                $this->reorderRoleIds(); // Panggil fungsi untuk mereset ID
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    private function reorderRoleIds()
    {
        foreach ($this->roles as $index => $role) {
            $role->role_id = $index + 1; // Set ulang ID berdasarkan indeks
        }
        $this->nextId = count($this->roles) + 1; // Perbarui nextId untuk addRole berikutnya
    }

    // public function deleteRole($role_id)
    // {
    //     foreach ($this->roles as $key => $role) {
    //         if ($role->role_id == $role_id) {
    //             unset($this->roles[$key]);
    //             $this->roles = array_values($this->roles);
    //             $this->saveToSession();
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    public function getRoleByName($role_name)
    {
        foreach ($this->roles as $role) {
            if ($role->role_name == $role_name) {
                return $role;
            }
        }
    }
}

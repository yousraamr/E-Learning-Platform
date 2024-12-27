<?php
require_once(__DIR__ . '/../models/AdminModel.php');

class AdminController
{
    private $admin;

    public function __construct()
    {
        $this->admin = new Admin();
    }

   
    public function getUserById(int $userId): ?array
    {
        return $this->admin->getUserById($userId);
    }

    
    public function addUser(string $username, string $email, string $password, string $usertype, array $courses = []): string
    {
        return $this->admin->addUser($username, $email, $password, $usertype, $courses);
    }

   
    public function editUser(int $userId, string $username, string $email, ?string $password, string $usertype, array $courses = []): string
    {
        return $this->admin->editUser($userId, $username, $email, $password, $usertype, $courses);
    }

   
    public function deleteUser(int $userId): string
    {
        return $this->admin->deleteUser($userId);
    }
}
?>
<?php
// src/Models/User.php

namespace App\Models;

class User
{
    private $connection;

    public function __construct()
    {
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'honeybee_schema';
        
        $this->connection = new \mysqli($host, $username, $password, $database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    
    public function getAllUsers()
    {
        $sql = "SELECT id, name, email, phone, role FROM users ORDER BY id DESC";
        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    
    public function getUserById($id)
    {
        $id = intval($id);
        $sql = "SELECT * FROM users WHERE id = $id";
        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

   
    public function createUser($data)
    {
        $name  = $this->connection->real_escape_string($data['name']);
        $email = $this->connection->real_escape_string($data['email']);
        $phone = $this->connection->real_escape_string($data['phone']);
        $role  = intval($data['role']);

        
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, phone, password, role)
                VALUES ('$name', '$email', '$phone', '$password', '$role')";

        $this->connection->query($sql);

        
    }

    
    public function updateUser($id, $data)
    {
        $id    = intval($id);
        $name  = $this->connection->real_escape_string($data['name']);
        $email = $this->connection->real_escape_string($data['email']);
        $phone = $this->connection->real_escape_string($data['phone']);
        $role  = intval($data['role']);

        
        if (!empty($data['password'])) {
            $password = password_hash($data['password'], PASSWORD_DEFAULT);

            $sql = "UPDATE users SET
                    name='$name',
                    email='$email',
                    phone='$phone',
                    password='$password',
                    role='$role'
                    WHERE id=$id";
        } else {
            $sql = "UPDATE users SET
                    name='$name',
                    email='$email',
                    phone='$phone',
                    role='$role'
                    WHERE id=$id";
        }

        $this->connection->query($sql);

        header("Location: /admin/user");
        exit;
    }

    
    public function deleteUser($id)
    {
        $id = intval($id);
        $this->connection->query("DELETE FROM users WHERE id=$id");

        header("Location: /admin/user");
        exit;
    }
    public function countUsers()
    {
        $sql = "SELECT COUNT(*) AS total FROM users";
        $result = $this->connection->query($sql);
        $row = $result->fetch_assoc();
        return (int)$row['total'];
    }
    public function canDelete($id) {
    $id = intval($id);
    $sql = "SELECT COUNT(*) total FROM donhang WHERE userId = $id";
    $result = $this->connection->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'] == 0;
    }
}


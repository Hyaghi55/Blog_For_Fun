<?php

namespace Services;

use Exception;
use Models\User;
use Helpers\Redirect;
use Services\Validation;

class UserService
{
    protected $db;
    protected $validation;

    public function __construct($db, Validation $validation)
    {
        $this->db = $db;
        $this->validation = $validation;
    }

    /**
     * Register a new user
     */
    public function register(string $name, string $email, string $password): bool
    {
        // Validate registration input
        if (!$this->validation->validateRegister($name, $email, $password)) {
            Redirect::withErrors($this->validation->getErrors())->back('register.php');
            return false;
        }

        // Check if the user already exists
        $existingUser = User::findByEmail($this->db, $email);
        if ($existingUser) {
            Redirect::withErrors(['email' => 'User already exists'])->back('register.php');
            return false;
        }

        // Hash the password and create a new user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create a new User model and save the user to the database
        $user = new User($this->db);
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $user->setCreatedAt();

        return $user->save();
    }

    /**
     * Authenticate a user (for login)
     */
    public function authenticate(string $email, string $password): ?User
    {
        // Validate login credentials
        if (!$this->validation->validateLogin($email, $password)) {
            Redirect::withErrors($this->validation->getErrors())->back('login.php');
            return null;
        }

        // Find user by email
        $user = User::findByEmail($this->db, $email);

        // Check password
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Authentication successful
        }

        // Invalid credentials
        Redirect::withErrors(['msg' => 'Invalid credentials'])->back('/login');
        return null;
    }

    /**
     * Get user by ID
     */
    public function getUserById(int $id): ?User
    {
        return User::findById($this->db, $id);
    }

    /**
     * Update user profile
     */
    public function updateProfile(int $id, string $name, string $email): bool
    {
        // Fetch the user by ID
        $user = $this->getUserById($id);

        if ($user) {
            $user->setName($name);
            $user->setEmail($email);
            return $user->save();
        }

        throw new Exception("User not found.");
    }
}

<?php

namespace Controllers;

use Models\User;
use Services\Database;
use Services\ENV;
use Services\UserService;
use Helpers\Redirect;
use Helpers\View;

class UserController
{
    private $env;
    private $baseUrl;
    private $userService;
    private $db;

    public function __construct(ENV $env, Database $db, UserService $userService)
    {
        $this->env = $env;
        $this->baseUrl = $this->env->getbaseurl();
        $this->db = $db->get_connection();
        $this->userService = $userService;
    }

    // Render registration form
    public function register()
    {
        $view = new View();
        return $view->render('register');
    }

    // Handle registration logic
    public function store(): void
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        // Validate password confirmation
        if ($password !== $confirmPassword) {
            Redirect::withErrors(['password' => 'Passwords do not match'])->back('register.php');
            return;
        }

        // Register the user
        $userRegistered = $this->userService->register($name, $email, $password);

        // Redirect based on registration result
        if ($userRegistered) {
            header('Location: ' . $this->baseUrl . '/login');
        } else {
            Redirect::withErrors(['email' => 'Unable to register user'])->back('register.php');
        }
    }

    // Render login form
    public function login()
    {
        $view = new View();
        return $view->render('login');
    }

    // Handle user authentication
    public function authenticate(): void
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Authenticate user
        $user = $this->userService->authenticate($email, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            header('Location: ' . $this->baseUrl . '/home');
        } else {
            Redirect::withErrors(['msg' => 'Invalid email or password'])->back('login');
        }
    }

    // Handle user logout
    public function logout(): void
    {
        session_destroy();
        Redirect::to('login');
    }
}

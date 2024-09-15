<?php

namespace Services;

class Validation
{
    private array $errors = [];

    // Class constants for validation rules 
    private const MIN_PASSWORD_LENGTH = 6;
    private const MAX_TITLE_LENGTH = 500;

    /**
     * Validate registration data (name, email, password)
     */
    public function validateRegister(string $name, string $email, string $password): bool
    {
        $this->validateRequired(['name' => $name, 'email' => $email, 'password' => $password]);

        if (!$this->validateEmail($email)) {
            $this->addError('email', 'Invalid email format.');
        }

        if (!$this->validatePassword($password)) {
            $this->addError('password', 'Password must be at least ' . self::MIN_PASSWORD_LENGTH . ' characters long.');
        }

        return empty($this->errors);
    }

    /**
     * Validate login credentials (email, password)
     */
    public function validateLogin(string $email, string $password): bool
    {
        $this->validateRequired(['email' => $email, 'password' => $password]);

        if (!$this->validateEmail($email)) {
            $this->addError('email', 'Invalid email format.');
        }

        if (!$this->validatePassword($password)) {
            $this->addError('password', 'Password must be at least ' . self::MIN_PASSWORD_LENGTH . ' characters long.');
        }

        return empty($this->errors);
    }

    /**
     * Validate image upload
     */
    public function validateImage(array $file): bool
    {
        $validTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($file['type'], $validTypes) || $file['size'] <= 0) {
            $this->addError('image', 'Invalid image file. Only JPEG, PNG, and GIF formats are allowed.');
            return false;
        }

        return true;
    }

    /**
     * Validate new post data (title, description)
     */
    public function validateNewPost(string $title, string $description): bool
    {
        $this->validateRequired(['title' => $title, 'description' => $description]);

        if (strlen($title) > self::MAX_TITLE_LENGTH) {
            $this->addError('title', 'Title must be less than ' . self::MAX_TITLE_LENGTH . ' characters.');
        }

        return empty($this->errors);
    }

    /**
     * Validate that required fields are not empty
     */
    private function validateRequired(array $data): void
    {
        foreach ($data as $field => $value) {
            if (empty($value)) {
                $this->addError($field, ucfirst($field) . ' is required.');
            }
        }
    }

    /**
     * Validate email format
     */
    private function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate password length
     */
    private function validatePassword(string $password): bool
    {
        return strlen($password) >= self::MIN_PASSWORD_LENGTH;
    }

    /**
     * Add validation error to the errors array
     */
    private function addError(string $field, string $message): void
    {
        $this->errors[$field] = $message;
    }

    /**
     * Get all validation errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Check if there are validation errors
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Clear validation errors
     */
    public function clearErrors(): void
    {
        $this->errors = [];
    }
}

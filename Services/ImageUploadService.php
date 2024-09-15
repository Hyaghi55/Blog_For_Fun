<?php

namespace Services;

class ImageUploadService
{
    protected string $uploadDirectory;

    public function __construct(string $uploadDirectory = '/uploads')
    {
        $this->uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . $uploadDirectory;
    }

    /**
     * Store the uploaded image.
     * 
     * @param array $file The uploaded file from $_FILES['image'].
     * @return string|null The file path of the uploaded image or null on failure.
     */
    public function store(array $file): ?string
    {
        if ($this->isValidImage($file)) {
            $uniqueFileName = $this->generateFileName($file['name']);
            $destination = $this->uploadDirectory . '/' . $uniqueFileName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $destination;
            }
        }

        return null;
    }

    /**
     * Validate the uploaded file.
     * 
     * @param array $file The uploaded file.
     * @return bool
     */
    protected function isValidImage(array $file): bool
    {
        $validTypes = ['image/jpeg', 'image/png', 'image/gif'];
        return in_array($file['type'], $validTypes) && $file['size'] > 0;
    }

    /**
     * Generate a unique file name for the uploaded image.
     * 
     * @param string $originalName The original file name.
     * @return string
     */
    protected function generateFileName(string $originalName): string
    {
        return uniqid() . '-' . basename($originalName);
    }
}

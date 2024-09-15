<?php

namespace Helpers;

class View
{
    protected $viewPath;

    public function __construct($viewPath = __DIR__ . '/../views/')
    {
        // Set the base path for view files
        $this->viewPath = rtrim($viewPath, '/') . '/';
    }

    /**
     * Render the view file
     * @param string $view - The view file name (without extension)
     * @param array $data - An associative array of data to pass to the view
     * @throws \Exception
     */
    public function render($view, array $data = [])
    {
        $filePath = $this->viewPath . $view . '.php';

        if (!file_exists($filePath)) {
            include(__DIR__ . '/../views/404.php');
        }

        // Extract the data array to variables
        extract($data);

        // Include the view file
        include($filePath);
    }
}

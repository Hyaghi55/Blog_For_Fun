<?php
// helpers.php


namespace Helpers;

session_start(); // Ensure the session is started

/**
 * Redirect class for handling redirects and error messages.
 */
class Redirect
{

    /**
     * Redirect to a specified URL.
     * 
     * @param string $url The URL to redirect to.
     * @param int $statusCode The HTTP status code for the redirect (default is 302).
     */
    public static function to($url, $statusCode = 302)
    {
        if (!headers_sent()) {
            http_response_code($statusCode);
            header('Location: ' . $url);
            exit();
        } else {
            echo "<script type='text/javascript'>window.location.href='$url';</script>";
            exit();
        }
    }

    /**
     * Redirect back to the previous page.
     * 
     * @param string $fallbackUrl URL to redirect to if the referrer is not available.
     */
    public static function back($fallbackUrl = 'index.php'): void
    {
        $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallbackUrl;
        self::to($url);
    }

    /**
     * Store error messages in the session.
     * 
     * @param array $errors Array of error messages.
     */
    public static function withErrors(array $errors): self
    {
        $_SESSION['errors'] = $errors;
        return new self();
    }

    /**
     * Retrieve and clear error messages from the session.
     * 
     * @return array Array of error messages.
     */
    public static function getErrors(): array
    {
        $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
        unset($_SESSION['errors']); // Clear errors after fetching
        return $errors;
    }
}

<?php
class SessionHelper {
    public static function init() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    public static function destroy() {
        session_unset();
        session_destroy();
        $_SESSION = array();
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public static function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    /**
     * Redirect to login page if user is not logged in.
     */
    public static function requireLogin() {
        self::init();
        if (!self::isLoggedIn()) {
            header('Location: ' . BASE_URL . '/User/login');
            exit;
        }
    }

    /**
     * Redirect to homepage if user is not an admin.
     */
    public static function requireAdmin() {
        self::init();
        if (!self::isLoggedIn()) {
            header('Location: ' . BASE_URL . '/User/login');
            exit;
        }
        if (!self::isAdmin()) {
            header('Location: ' . BASE_URL . '/Product/list');
            exit;
        }
    }
}
?>

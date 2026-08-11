<?php

namespace App\Core;

class Auth
{
    // Funciona ✅
    public static function initSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            $isSecure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';

            session_start([
                'cookie_lifetime' => 86400,
                'cookie_secure'   => $isSecure,
                'cookie_httponly' => true,
                'cookie_samesite' => 'Strict',
                'use_only_cookies' => true
            ]);
        }
    }


    public static function check(?string $requiredRol = null): bool
    {
        self::initSession();

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_rol'])) {
            return false;
        }
        if ($requiredRol !== null && $_SESSION['user_rol'] !== $requiredRol) {
            return false;
        }

        return true;
    }

    // En App/Core/Auth.php

    public static function login(int $userId, string $userRol, array $userData = []): void
    {
        self::initSession();
        session_regenerate_id(true);

        $_SESSION['user_id'] = $userId;
        $_SESSION['user_rol'] = $userRol;
        $_SESSION['last_activity'] = time();

        if (!empty($userData)) {
            $_SESSION['user_nombre'] = $userData['nombre'] ?? '';
            $_SESSION['user_apellido'] = $userData['apellido'] ?? '';
            $_SESSION['user_cedula'] = $userData['cedula'] ?? '';
            $_SESSION['user_estado'] = $userData['estado'] ?? 0;
            $_SESSION['user_primer_ingreso'] = $userData['primer_ingreso'] ?? 0;
        }
    }


    public static function logout(): void
    {
        self::initSession();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy();
    }
}

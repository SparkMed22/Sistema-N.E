<?php

namespace App\Controllers;

use Exception;

abstract class BaseController
{

    // FUNCIONA ✅
    protected function json($data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // FUNCIONA ✅
    protected function success($data, string $message = 'OK'): void
    {
        $this->json([
            'success' => true,
            'message' => $message,
            'data'    => $data
        ]);
    }

    // FUNCIONA ✅
    protected function error(string $message, int $status = 400): void
    {
        $this->json([
            'success' => false,
            'message' => $message
        ], $status);
        exit;
    }

    // FUNCIONA ✅
    protected function input(): array
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    // FUNCIONA ✅
    protected function getPostJson()
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Formato de datos inválido');
        }
        return $data;
    }
}
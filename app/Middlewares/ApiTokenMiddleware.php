<?php
namespace Middlewares;

use Src\Request;
use Model\Employee;

class ApiTokenMiddleware
{
    public function handle(Request $request): void
    {
        $authHeader = $request->headers['Authorization'] ?? '';

        if (!preg_match('/Bearer\s+(.+)$/i', $authHeader, $matches)) {
            http_response_code(401);
            echo json_encode(['error' => 'Token not provided']);
            exit;
        }

        $token = $matches[1];

        $user = Employee::where('api_token', $token)->first();

        if (!$user) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid token']);
            exit;
        }

        $request->authUser = $user;
    }
}
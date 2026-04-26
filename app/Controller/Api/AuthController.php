<?php
namespace Controller\Api;

use Src\Request;
use Src\View;
use Model\Employee;
use Model\Role;

class AuthController
{
    /**
     * POST /api/auth/login
     */
    public function login(Request $request): void
    {
        $login = $request->all()['login'] ?? '';
        $password = $request->all()['password'] ?? '';

        $user = Employee::where('login', $login)->first();

        if (!$user || md5($password) !== $user->password) {
            http_response_code(401);
            (new View())->toJSON(['error' => 'Invalid credentials']);
            return;
        }

        $token = bin2hex(random_bytes(32));

        $user->api_token = $token;
        $user->save();

        (new View())->toJSON([
            'success' => true,
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'login' => $user->login,
                'full_name' => $user->full_name,
            ]
        ]);
    }

    /**
     * POST /api/auth/logout
     */
    public function logout(Request $request): void
    {
        if (isset($request->authUser)) {
            $request->authUser->api_token = null;
            $request->authUser->save();
        }

        (new View())->toJSON(['success' => true, 'message' => 'Logged out']);
    }
}
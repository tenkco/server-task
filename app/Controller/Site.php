<?php
namespace Controller;

use Model\Post;
use Src\View;
use Src\Request;
use Model\User;
use Src\Auth\Auth;

class Site
{
    public function index(Request $request): string
    {
        $posts = Post::where('id', $request->id)->get();
        return (new View())->render('site.post', ['posts' => $posts]);
    }

    public function hello(): string
    {
        return (new View())->render('site.hello', ['message' => 'hello working']);
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            if (User::create($request->all())) {
                app()->route->redirect('/equipment');
            }
        }
        return (new View())->render('site.signup');
    }

    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return (new View())->render('site.login');
        }

        if (Auth::attempt($request->all())) {
            app()->route->redirect('/equipment');
        }

        return (new View())->render('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/login');
    }
}
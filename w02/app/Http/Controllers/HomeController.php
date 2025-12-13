<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = "Welcome to Our Laravel MVC Application";
        return view('home', compact('title'));
    }

    public function about()
    {
        $info = "This page demonstrates how data is passed from a controller to a Blade view in Laravel.";
        return view('about', compact('info'));
    }

    public function features()
    {
        $features = [
            "MVC Architecture",
            "Blade Templating Engine",
            "Routing System",
            "Eloquent ORM",
            "Security and Authentication"
        ];

        return view('features', compact('features'));
    }

    public function team()
    {
        $team = [
            ['name' => 'mo7ammed', 'role' => 'Backend Developer'],
            ['name' => 'ahmad', 'role' => 'Frontend Developer'],
            ['name' => 'ali', 'role' => 'UI/UX Designer'],
        ];

        return view('team', compact('team'));
    }
}

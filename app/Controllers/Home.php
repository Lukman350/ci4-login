<?php

namespace App\Controllers;

use App\Models\User;

class Home extends BaseController
{
  public function index(): string
  {
    $user = new User();

    $data = [
      'users' => $user->findAll()
    ];

    return view('templates/header', ['title' => 'Home Page']) . view('home', $data) . view('templates/footer');
  }
}

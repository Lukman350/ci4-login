<?php

namespace App\Controllers;

use App\Models\User;

class Auth extends BaseController
{
    public function register()
    {
        if ($this->request->is('post')) {
            $user = new User();

            $form_rules = $user->getValidationRules();

            $form_rules['confirm_password'] = 'required|matches[password]';

            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'confirm_password' => $this->request->getPost('confirm_password')
            ];

            $file_rules = [
                'profile' => [
                    'label' => 'Profile Picture',
                    'rules' => [
                        'max_size[profile,1024]',
                        'mime_in[profile,image/jpg,image/jpeg,image/png]',
                    ],
                ],
            ];

            if (!$this->validate($file_rules)) {
                return view('templates/header', ['title' => 'Register Page']) . view('register', [
                    'validation' => $this->validator,
                    'fields' => $data,
                ]) . view('templates/footer');
            }

            if ($this->validateData($data, $form_rules, $user->getValidationMessages())) {
                $file = $this->request->getFile('profile');

                $profile_name = 'default.jpg';

                if ($file->isValid() && !$file->hasMoved()) {
                    $profile_name = $file->getRandomName();

                    $file->move(ROOTPATH . './public/images/uploads/', $profile_name);
                }

                $password = $data['password'];

                if ($user->allowEmptyInserts()->insert([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => password_hash($password ?? '', PASSWORD_BCRYPT),
                    'profile' => $profile_name,
                ])) {
                    return redirect()->to('/auth/login');
                } else {
                    $this->validator->setError('email', 'Failed to register user');

                    return view('templates/header', ['title' => 'Register Page']) . view('register', [
                        'validation' => $this->validator,
                        'fields' => $data,
                    ]) . view('templates/footer');
                }
            } else {
                return view('templates/header', ['title' => 'Register Page']) . view('register', [
                    'validation' => $this->validator,
                    'fields' => $data,
                ]) . view('templates/footer');
            }
        }

        return view('templates/header', ['title' => 'Register Page']) . view('register') . view('templates/footer');
    }

    public function login(): string
    {
        if ($this->request->is('post')) {
            $user = new User();

            $data = [
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
            ];

            $form_rules = [
                'email' => 'required|valid_email',
                'password' => 'required',
            ];

            if ($this->validateData($data, $form_rules, $user->getValidationMessages())) {
                $user = $user->where('email', $data['email'])->first();

                if ($user && password_verify($data['password'] ?? '', $user['password'])) {
                    $session = session();

                    $data = [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'profile' => $user['profile'],
                    ];

                    $session->set($data);

                    return redirect()->to('/home');
                } else {
                    $this->validator->setError('email', 'Email or password is incorrect');
                    $this->validator->setError('password', '');
                }
            } else {
                return view('templates/header', ['title' => 'Login Page']) . view('login', [
                    'validation' => $this->validator,
                    'fields' => $data,
                ]) . view('templates/footer');
            }
        }

        return view('templates/header', ['title' => 'Login Page']) . view('login') . view('templates/footer');
    }
}

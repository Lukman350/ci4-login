<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\HTTP\URI;

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

    public function login()
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
                $userDB = $user->where('email', $data['email'])->first();

                if (empty($userDB)) {
                    $this->validator->setError('email', 'Email is not registered yet');

                    return view('templates/header', ['title' => 'Login Page']) . view('login', [
                        'validation' => $this->validator,
                        'fields' => $data,
                    ]) . view('templates/footer');
                }

                if (!password_verify($data['password'] ?? '', $userDB['password'])) {
                    $this->validator->setError('password', 'Invalid password');

                    return view('templates/header', ['title' => 'Login Page']) . view('login', [
                        'validation' => $this->validator,
                        'fields' => $data,
                    ]) . view('templates/footer');
                }

                $session = session();

                $data = [
                    'id' => $userDB['id'],
                    'name' => $userDB['name'],
                    'email' => $userDB['email'],
                    'profile' => $userDB['profile'],
                ];

                $session->set($data);

                return redirect()->to('/home');
            } else {
                return view('templates/header', ['title' => 'Login Page']) . view('login', [
                    'validation' => $this->validator,
                    'fields' => $data,
                ]) . view('templates/footer');
            }
        }

        return view('templates/header', ['title' => 'Login Page']) . view('login') . view('templates/footer');
    }

    public function forgotPassword(): string | \CodeIgniter\HTTP\RedirectResponse
    {
        if ($this->request->is('post')) {
            $user = new User();

            $data = [
                'email' => $this->request->getPost('email'),
            ];

            $form_rules = [
                'email' => 'required|valid_email',
            ];

            if ($this->validateData($data, $form_rules, $user->getValidationMessages())) {
                $userDB = $user->where('email', $data['email'])->first();

                if (empty($userDB)) {
                    $this->validator->setError('email', 'Email is not registered yet');

                    return view('templates/header', ['title' => 'Forgot Password Page']) . view('forgot_password', [
                        'validation' => $this->validator,
                        'fields' => $data,
                    ]) . view('templates/footer');
                }

                $token = base64_encode(random_bytes(32));

                $user->update($userDB['id'], ['token' => $token]);

                $email = \Config\Services::email();

                $email->setMailType('html');
                $email->setFrom(getenv('email.SMTPUser'), 'Coralis Studio');
                $email->setTo($data['email']);

                $email->setSubject('Reset Password');
                $email->setMessage(view('templates/email/reset_password', ['token' => $token, 'name' => $userDB['name']]));

                if ($email->send()) {
                    return redirect()->to('/auth/login')->with('success', 'Email has been sent');
                } else {
                    $this->validator->setError('email', 'Failed to send email');

                    return view('templates/header', ['title' => 'Forgot Password Page']) . view('forgot_password', [
                        'validation' => $this->validator,
                        'fields' => $data,
                    ]) . view('templates/footer');
                }
            } else {
                return view('templates/header', ['title' => 'Forgot Password Page']) . view('forgot_password', [
                    'validation' => $this->validator,
                    'fields' => $data,
                ]) . view('templates/footer');
            }
        }

        return view('templates/header', ['title' => 'Forgot Password Page']) . view('forgot_password') . view('templates/footer');
    }

    public function resetPassword(): string | \CodeIgniter\HTTP\RedirectResponse
    {
        $token = $this->request->getGet('token');
        if (empty($token) && $this->request->is('get')) {
            return redirect()->to('/auth/login');
        }

        if ($this->request->is('post')) {
            $user = new User();

            $data = [
                'password' => $this->request->getPost('password'),
                'confirm_password' => $this->request->getPost('confirm_password'),
            ];

            $form_rules = [
                'password' => 'required|min_length[8]',
                'confirm_password' => 'required|matches[password]',
            ];

            $this->request->setHeader('Accept', 'application/json');
            $this->request->setHeader('Content-Type', 'application/json');

            if ($this->validateData($data, $form_rules, $user->getValidationMessages())) {
                $userDB = $user->where('token', $token)->first();

                if (empty($userDB)) {
                    return json_encode(['success' => false, 'message' => 'Invalid token']);
                }

                $user->update($userDB['id'], [
                    'password' => password_hash($data['password'] ?? '', PASSWORD_BCRYPT),
                    'token' => null,
                ]);

                return json_encode(['success' => true]);
            } else {
                return json_encode(['success' => false, 'message' => $this->validator->getErrors()]);
            }
        }

        return view('templates/header', ['title' => 'Reset Password Page']) . view('reset_password') . view('templates/footer');
    }
}

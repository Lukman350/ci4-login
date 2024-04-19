<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
  protected $table = 'users';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $allowedFields = ['name', 'email', 'password', 'profile', 'token', 'created_at', 'updated_at'];
  protected $useTimestamps = true;
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';
  protected $returnType = 'array';
  protected $useSoftDeletes = false;
  protected $validationRules = [
    'name' => 'required',
    'email' => 'required|valid_email|is_unique[users.email]',
    'password' => 'required|min_length[8]'
  ];
  protected $validationMessages = [
    'email' => [
      'required' => 'Email is required',
      'is_unique' => 'Sorry. That email has already been taken. Please choose another.',
    ],
    'password' => [
      'required' => 'Password is required',
      'min_length' => 'Password is too short. It must be at least 8 characters long',
    ],
    'profile' => [
      'max_size' => 'Maximum file size is 1MB',
      'is_image' => 'Please choose an image file',
      'mime_in' => 'Invalid file type. Only JPG, JPEG, and PNG are allowed',
    ]
  ];
  protected $skipValidation = false;
}

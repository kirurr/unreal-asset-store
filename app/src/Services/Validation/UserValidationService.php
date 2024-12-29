<?php

namespace Services\Validation;

class UserValidationService
{
    /**
     * @return array{ 0: array<string, string>, 1: array{ email: string, password: string } }
     */
    public function validateSignIn(string $email, string $password): array
    {
        $vemail = htmlspecialchars(trim($email));
        $vpassword = htmlspecialchars(trim($password));

        $errors = [];

        if (empty($vemail)) {
            $errors['email'] = 'Email is required';
        } elseif(preg_match('/.*@.*\..*/', $email) == 0) {
            $errors['email'] = 'Email is invalid';
        }

        if (empty($vpassword)) {
            $errors['password'] = 'Password is required';
        }
        return [$errors, ['email' => $vemail, 'password' => $vpassword]];
    }

    /**
     * @return array{ 0: array<string, string>, 1: array{ email: string, password: string, name: string } }
     */
    public function validateSignUp(string $name, string $password, string $email): array
    {
    
        $vemail = htmlspecialchars(trim($email));
        $vpassword = htmlspecialchars(trim($password));
        $vname = htmlspecialchars(trim($name));

        $errors = [];
        if (empty($vemail)) {
            $errors['email'] = 'Email is required';
        } elseif(preg_match('/.*@.*\..*/', $email) == 0) {
            $errors['email'] = 'Email is invalid';
        }
        if (empty($vpassword)) {
            $errors['password'] = 'Password is required';
        }
        if (empty($vname)) {
            $errors['name'] = 'Name is required';
        }
        return [$errors, ['email' => $vemail, 'password' => $vpassword, 'name' => $vname]];
    }

    /**
     * @return array{ 0: array<string, string>, 1: array{ email: string, password: string, name: string, role: string } }
     */
    public function validateUpdate(string $name, string $password, string $email, string $role): array
    {
    
        $vemail = htmlspecialchars(trim($email));
        $vpassword = htmlspecialchars(trim($password));
        $vname = htmlspecialchars(trim($name));
        $vrole = htmlspecialchars(trim($role));

        $errors = [];
        if (empty($vemail)) {
            $errors['email'] = 'Email is required';
        } elseif(preg_match('/.*@.*\..*/', $email) == 0) {
            $errors['email'] = 'Email is invalid';
        }
        if (empty($vname)) {
            $errors['name'] = 'Name is required';
        }
        if (empty($vrole)) {
            $errors['role'] = 'Role is required';
        }
        return [$errors, ['email' => $vemail, 'password' => $vpassword, 'name' => $vname, 'role' => $vrole]];
    }
}

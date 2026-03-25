<?php
declare(strict_types=1);

class Auth
{
    public function __construct(private readonly User $userModel)
    {
    }

    public function register(array $data, array &$errors): bool
    {
        $errors = Validator::validateRegister($data);
        if (!empty($errors)) {
            return false;
        }

        if ($this->userModel->emailExists($data['email'])) {
            $errors['email'] = 'Email is already registered.';
            return false;
        }

        return $this->userModel->create(
            Validator::clean($data['full_name']),
            strtolower(trim($data['email'])),
            $data['password'],
            'user'
        );
    }

    public function login(string $email, string $password, array &$errors): bool
    {
        $errors = Validator::validateLogin([
            'email' => $email,
            'password' => $password,
        ]);

        if (!empty($errors)) {
            return false;
        }

        $user = $this->userModel->findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            $errors['general'] = 'Invalid email or password.';
            return false;
        }

        Session::set('user', [
            'id' => (int) $user['id'],
            'full_name' => $user['full_name'],
            'email' => $user['email'],
            'role_id' => (int) $user['role_id'],
            'role_name' => $user['role_name'],
        ]);

        return true;
    }

    public static function user(): ?array
    {
        return Session::get('user');
    }

    public static function check(): bool
    {
        return Session::has('user');
    }

    public static function isAdmin(): bool
    {
        $user = self::user();
        return $user !== null && (($user['role_name'] ?? '') === 'admin');
    }

    public static function logout(): void
    {
        Session::remove('user');
        Session::flash('success', 'You have logged out.');
    }
}

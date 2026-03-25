<?php
declare(strict_types=1);

class Validator
{
    public static function clean(string $value): string
    {
        return trim(filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS));
    }

    public static function validateRegister(array $data): array
    {
        $errors = [];
        $name = trim($data['full_name'] ?? '');
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';
        $confirm = $data['confirm_password'] ?? '';

        if ($name === '') {
            $errors['full_name'] = 'Full name is required.';
        } elseif (mb_strlen($name) < 3) {
            $errors['full_name'] = 'Full name must be at least 3 characters.';
        }

        if ($email === '') {
            $errors['email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format.';
        }

        if ($password === '') {
            $errors['password'] = 'Password is required.';
        } elseif (strlen($password) < 8) {
            $errors['password'] = 'Password must be at least 8 characters.';
        }

        if ($confirm === '') {
            $errors['confirm_password'] = 'Confirm password is required.';
        } elseif ($confirm !== $password) {
            $errors['confirm_password'] = 'Passwords do not match.';
        }

        return $errors;
    }

    public static function sanitizeStorage(string $value): string
    {
        $value = str_replace("\0", '', trim($value));
        return strip_tags($value);
    }

    public static function sanitizeStorageMultiline(string $value): string
    {
        $value = str_replace("\0", '', trim($value));
        return strip_tags($value);
    }

    public static function validateLogin(array $data): array
    {
        $errors = [];
        $email = trim($data['email'] ?? '');
        $password = trim($data['password'] ?? '');

        if ($email === '') {
            $errors['email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format.';
        }

        if ($password === '') {
            $errors['password'] = 'Password is required.';
        }

        return $errors;
    }

    public static function validateContact(array $data): array
    {
        $errors = [];
        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        $subject = trim($data['subject'] ?? '');
        $message = trim($data['message'] ?? '');

        if ($name === '') {
            $errors['name'] = 'Name is required.';
        }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'A valid email is required.';
        }
        if ($subject === '') {
            $errors['subject'] = 'Subject is required.';
        }
        if ($message === '') {
            $errors['message'] = 'Message is required.';
        } elseif (mb_strlen($message) < 10) {
            $errors['message'] = 'Message must be at least 10 characters.';
        }

        return $errors;
    }

    public static function validateContent(array $data, bool $withShortDescription = false): array
    {
        $errors = [];
        $title = trim($data['title'] ?? '');
        $body = trim($data['body'] ?? '');

        if ($title === '') {
            $errors['title'] = 'Title is required.';
        }
        if ($body === '') {
            $errors['body'] = 'Body is required.';
        }

        if ($withShortDescription) {
            $short = trim($data['short_description'] ?? '');
            if ($short === '') {
                $errors['short_description'] = 'Short description is required.';
            }
        }

        return $errors;
    }
}

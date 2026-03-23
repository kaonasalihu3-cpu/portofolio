<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function app_url(string $path = ''): string
{
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

function redirect(string $path): never
{
    header('Location: ' . app_url($path));
    exit;
}

function current_user(): ?array
{
    return Auth::user();
}

function is_admin(): bool
{
    return Auth::isAdmin();
}

function active_nav(string $page): string
{
    $current = basename($_SERVER['PHP_SELF']);
    return $current === $page ? 'active' : '';
}

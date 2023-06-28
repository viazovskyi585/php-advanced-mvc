<?php

use App\Helpers\Session;
use App\Models\Folder;
use Config\Config;
use Core\View;

function config(string $name): string|null
{
    return Config::get($name);
}

function view(string $viewName, array $args = []): void
{
    View::render($viewName, $args);
}

function url(string $path = ''): string
{
    return SITE_URL . '/' . $path;
}

function urlBack(): string
{
    return $_SERVER['HTTP_REFERER'] ?? url();
}

function redirect(string $path = ''): void
{
    header('Location: ' . url($path));
    exit;
}

function redirectBack(string $path = ''): void
{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

function getFieldError(string $field, array $errors): string
{
    return isset($errors[$field]) ? $errors[$field][0] : '';
}

function getFieldState(string $error): string
{
    return $error ? 'is-invalid' : '';
}

function isCurrentLink(string $path): bool
{
    return trim($_SERVER['REQUEST_URI'], '/') === $path;
}

function findObjectById(array $array, int $id): object|null
{
    foreach ($array as $element) {
        if ($id == $element->id) {
            return $element;
        }
    }

    return false;
}

function getAndResetNotifications(): array
{
    $notications = Session::getNotifications();
    Session::flushNotifications();

    return $notications;
}

function isCurrentUser(int $id): bool
{
    return Session::id() === $id;
}

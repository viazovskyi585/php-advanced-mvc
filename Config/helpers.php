<?php

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

function url(string $path): string
{
    return SITE_URL . '/' . $path;
}

function redirect(string $path): void
{
    header('Location: ' . url($path));
    exit;
}

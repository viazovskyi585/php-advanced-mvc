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

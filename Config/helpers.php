<?php

use Config\Config;

function config(string $name): string|null
{
    return Config::get($name);
}

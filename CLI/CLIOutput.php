<?php
namespace CLI;

class CLIOutput
{
    public static function print(string $message): void
    {
        echo "$message\n";
    }

    public static function error(string $message): void
    {
        echo "\033[1;31m$message\033[0m\n";
    }

    public static function warning(string $message): void
    {
        echo "\033[1;33m$message\033[0m\n";
    }

    public static function success(string $message): void
    {
        echo "\033[0;32m$message\033[0m\n";
    }

    public static function bold(string $message): void
    {
        echo "\033[1m$message\033[0m\n";
    }
}

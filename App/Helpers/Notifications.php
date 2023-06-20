<?php

namespace App\Helpers;

class Notifications
{
	static protected array $notifications = [];

	static public function get(): array
	{
		return self::$notifications;
	}

	static public function notify(string $message, string $type = 'primary'): void
	{
		self::$notifications[] = compact('message', 'type');
	}

	static public function flush(): void
	{
		self::$notifications = [];
	}
}

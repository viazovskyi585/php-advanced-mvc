<?php

namespace App\Helpers;

class Session
{
	static public function check(): bool
	{
		return !empty($_SESSION['user_data']);
	}

	static public function id(): int|null
	{
		return $_SESSION['user_data']['id'] ?? null;
	}

	static public function setUserData(int $id, array $options = []): void
	{
		$data = array_merge(
			compact('id'),
			$options
		);

		$_SESSION['user_data'] = array_merge(
			$_SESSION['user_data'] ?? [],
			$data
		);
	}

	static public function destroy(): void
	{
		if (session_id()) {
			session_destroy();
		}
	}

	static public function notify(string $message, string $type = 'primary'): void
	{
		$_SESSION['notifications'][] = compact('message', 'type');
	}

	static public function getNotifications(): array
	{
		return $_SESSION['notifications'] ?? [];
	}

	static public function flushNotifications(): void
	{
		unset($_SESSION['notifications']);
	}
}

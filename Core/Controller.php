<?php

namespace Core;

class Controller
{
	public function before(string $action, array $params = []): bool
	{
		return true;
	}

	public function after(string $action): void
	{
	}
}

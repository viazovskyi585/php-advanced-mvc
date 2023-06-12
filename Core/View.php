<?php
namespace Core;

class View
{
	static public function render(string $viewName, array $args = []): void
	{
		$file =  VIEW_DIR . $viewName . '.php';

		if (!is_readable($file)) {
			throw new \Exception("View file [$file] not found.", 404);
		}

		extract($args, EXTR_SKIP);

		require $file;
	}
}

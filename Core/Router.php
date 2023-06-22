<?php

namespace Core;

class Router
{
	static protected array $routes = [], $params = [];

	static protected array $convertTypes = [
		'd' => 'int',
		'D' => 'string',
	];

	static public function add(string $route, array $params): void
	{
		$routeRegex = preg_replace('/\//', '\\/', $route);
		$routeRegex = preg_replace('/\{([a-z_]+):([^\}]+)\}/', '(?P<\1>\2)', $routeRegex);
		$routeRegex = '/^' . $routeRegex . '$/i';
		static::$routes[$routeRegex] = $params;
	}

	static public function dispatch(string $url): void
	{
		$parsed = parse_url($url);
		$path = trim($parsed['path'], '/');
		$query = $parsed['query'] ?? null;

		if (!static::match($path)) {
			throw new \Exception("Route [$path] not found.", 404);
		}

		static::checkRequestMethod();

		$controller = static::getController();
		$action = static::getAction($controller);

		if ($controller->before($action, static::$params)) {
			call_user_func_array([$controller, $action], static::$params);
			$controller->after($action);
		}
	}

	static protected function match(string $url): bool
	{
		foreach (static::$routes as $route => $params) {
			if (preg_match($route, $url, $matches)) {
				static::$params = static::getRouteParams($route, $matches, $params);
				return true;
			}
		}
		return false;
	}

	static protected function getRouteParams(string $route, array $matches, array $params): array
	{
		preg_match_all('/\(\?P<[\w]+>\\\\(\w[\+]*)\)/', $route, $types);
		$matches = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

		if (!empty($types)) {
			$lastKey = array_key_last($types);
			$step = 0;
			$types[$lastKey] = str_replace('+', '', $types[$lastKey]);

			foreach ($matches as $name => $match) {
				settype($match, static::$convertTypes[$types[$lastKey][$step]]);
				$params[$name] = $match;
				$step++;
			}
		}

		return $params;
	}

	static protected function checkRequestMethod(): void
	{
		if (array_key_exists('method', static::$params)) {
			$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

			if (strtolower(static::$params['method']) !== $requestMethod) {
				throw new \Exception("Method [$requestMethod] not allowed for this route.", 405);
			}

			unset(static::$params['method']);
		} else {
			throw new \Exception("Method not specified for this route.", 405);
		}
	}

	static protected function getController(): Controller
	{
		$controller = static::$params['controller'] ?? null;

		if (!class_exists($controller)) {
			throw new \Exception("Controller [$controller] not found.", 404);
		}

		unset(static::$params['controller']);

		return new $controller;
	}

	static protected function getAction(Controller $controller): string
	{
		$action = static::$params['action'] ?? null;

		if (!method_exists($controller, $action)) {
			throw new \Exception("Action [$action] not found.", 404);
		}

		unset(static::$params['action']);

		return $action;
	}
}

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

		if (static::match($path)) {
			d('match');
		}
	}

	protected static function match(string $url): bool
	{
		foreach (static::$routes as $route => $params) {
			if (preg_match($route, $url, $matches)) {
				static::$params = static::getRouteParams($route, $matches, $params);
				return true;
			}
		}
		return false;
	}

	protected static function getRouteParams(string $route, array $matches, array $params): array
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
}

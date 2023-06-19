<?php

namespace Core\Traits;

use Core\Db;
use PDO;

trait Queryable
{
	static protected string $tableName;

	static protected string $query = '';

	static protected array $commands = [];

	static protected function resetQuery(): void
	{
		static::$query = '';
		static::$commands = [];
	}

	protected function getId(): int
	{
		if (!isset($this->id)) {
			throw new \Exception("[Queryable]: Model does not have an id");
		}

		return $this->id;
	}

	public function get(): array
	{
		$result =  Db::connect()->query(static::$query)->fetchAll(PDO::FETCH_CLASS, static::class);
		static::resetQuery();
		return $result;
	}

	static public function select(array $columns = ['*']): self
	{
		static::$query .= 'SELECT ' . implode(', ', $columns) . ' FROM ' . static::$tableName . ' ';

		$obj = new static;
		static::$commands[] = 'select';

		return $obj;
	}

	static public function find(int $id): static|false
	{
		$dbh = Db::connect()->prepare('SELECT * FROM ' . static::$tableName . ' WHERE id = :id');
		$dbh->bindParam(':id', $id);
		$dbh->execute();

		return $dbh->fetchObject(static::class);
	}

	static public function findBy(string $column, mixed $value): static|false
	{
		$dbh = Db::connect()->prepare("SELECT * FROM " . static::$tableName . " WHERE {$column} = :{$column}");
		$dbh->bindParam($column, $value);
		$dbh->execute();

		return $dbh->fetchObject(static::class);
	}

	static public function create(array $fields): false|int
	{
		$params = static::prepareQueryParams($fields);

		$query = "INSERT INTO " . static::$tableName . " ({$params['keys']}) VALUES ({$params['placeholders']})";
		$dbh = Db::connect()->prepare($query);

		if (!$dbh->execute($fields)) {
			return false;
		}

		return (int) Db::connect()->lastInsertId();
	}

	static protected function prepareQueryParams(array $fields): array
	{
		$keys = array_keys($fields);
		$placeholders = preg_filter('/^/', ':', $keys);

		return [
			'keys' => implode(', ', $keys),
			'placeholders' => implode(', ', $placeholders)
		];
	}

	public function update(array $fields): bool
	{
		$query = "UPDATE " . static::$tableName . " SET" . $this->updatePlaceholders(array_keys($fields)) . " WHERE id=:id";
		$query = Db::connect()->prepare($query);
		$fields['id'] = $this->getId();

		return $query->execute($fields);
	}

	public function destroy(): bool
	{
		$query = "DELETE FROM " . static::$tableName . " WHERE id=:id";
		$query = Db::connect()->prepare($query);

		return $query->execute(['id' => $this->getId()]);
	}

	public function where(string $column, string $operator, $value): static
	{
		if ($this->prevent(['group', 'limit', 'order', 'having'])) {
			throw new \Exception("[Queryable]: WHERE can not be used after ['group', 'limit', 'order', 'having']");
		}

		$obj = in_array('select', static::$commands) ? $this : static::select();

		if (!is_bool($value) && !is_numeric($value) && $operator !== 'IN') {
			$value = "'{$value}'";
		}

		if (!in_array("where", static::$commands)) {
			static::$query .= " WHERE";
		}

		static::$query .= " {$column} {$operator} {$value}";
		static::$commands[] = 'where';

		return $obj;
	}

	public function andWhere(string $column, string $operator, $value): static
	{
		static::$query .= " AND";
		return $this->where($column, $operator, $value);
	}

	public function orWhere(string $column, string $operator, $value): static
	{
		static::$query .= " OR";
		return $this->where($column, $operator, $value);
	}

	public function whereIn(string $column, array $value, $type = 'AND'): static
	{
		if (in_array('where', static::$commands)) {
			static::$query .= " {$type}";
		}

		$value = "(" . implode(',', $value) . ") ";

		return $this->where($column, 'IN', $value);
	}

	public function orderBy(string $column, string $sqlOrder = 'ASC'): static
	{
		if (!$this->prevent(['select'])) {
			throw new \Exception("[Queryable]: ORDER BY can not be before ['select']");
		}

		static::$commands[] = 'order';

		static::$query .= " ORDER BY {$column} " . $sqlOrder;

		return $this;
	}

	public function getSqlQuery(): string
	{
		return static::$query;
	}

	protected function prevent(array $allowedMethods): bool
	{
		foreach ($allowedMethods as $method) {
			if (in_array($method, static::$commands)) {
				return true;
			}
		}

		return false;
	}

	protected function updatePlaceholders(array $keys): string
	{
		$string = "";
		$lastKey = array_key_last($keys);

		foreach ($keys as $index => $key) {
			$string .= " {$key}=:{$key}" . ($lastKey === $index ? '' : ',');
		}

		return $string;
	}
}

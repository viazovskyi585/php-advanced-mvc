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

	static public function create(array $fields): int
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
		if (!$this->getId()) {
			throw new \Exception("[Queryable]: Model does not have an id");
		}

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

	public function whereNotIn(string $column, array $value, $type = 'AND'): static
	{
		if (in_array('where', static::$commands[])) {
			static::$query .= " {$type}";
		}

		$value = "(" . implode(',', $value) . ") ";

		return $this->where($column, 'NOT IN', $value);
	}

	public function orderBy(array $columns, string $sqlOrder = 'ASC'): static
	{
		if (!$this->prevent(['select'])) {
			throw new \Exception("[Queryable]: ORDER BY can not be before ['select']");
		}

		static::$commands[] = 'order';

		static::$query .= " ORDER BY ";

		$lastKey = array_key_last($columns);
		foreach ($columns as $column => $order) {
			static::$query .= " {$column} {$order}" . ($column === $lastKey ? '' : ',');
		}

		return $this;
	}

	public function getSqlQuery(): string
	{
		$query = static::$query;
		static::resetQuery();
		return $query;
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

	public function groupBy(array $columns): static
	{
		if (!$this->prevent(['select'])) {
			throw new \Exception("[Queryable]: GROUP BY can not be before ['select']");
		}

		static::$commands[] = 'group';

		static::$query .= " GROUP BY " . implode(', ', $columns);

		return $this;
	}

	public function join(string $table, string $t1Column, string $t2Column, string $operator = '=', string $type = 'LEFT'): static
	{
		if (!$this->prevent(['select'])) {
			throw new \Exception("[Queryable]: {$type} JOIN can not be before ['select']");
		}

		static::$commands[] = 'join';

		static::$query .= " {$type} JOIN {$table} ON {$t1Column} {$operator} {$t2Column}";

		return $this;
	}

	public function pluck(string $column): array
	{
		$result = $this->get();
		$newArr = [];

		foreach ($result as $item) {
			$newArr[] = $item->$column;
		}

		return $newArr;
	}
}

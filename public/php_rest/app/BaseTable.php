<?php

namespace App;

use App\DataBase\DB;
use PDOStatement;

abstract class BaseTable
{
	abstract public static function getTableName(): string;

	abstract public static function getDTO(): array;

	/**
	 * @return array{
	 *        table: string,
	 *        this_key: string,
	 *        remote_key: string
	 * }
	 */
	abstract protected static function getJoinInfo(): array;

	public static function add($values): ?PDOStatement
	{
		$prepare = [];
		$columns = [];

		foreach ($values as $column => $value)
		{
			if ($column != 'id')
			{
				$temp = static::getAlias($column);

				$prepare[$temp] = $value;
				$columns[] = $column;
			}
		}

		$sql = "insert into " . static::getTableName() . " (" . implode(', ', $columns) . ") values (" . implode(' ,', array_keys($prepare)) . ")";

		return static::exec($sql, $prepare);
	}

	public static function get(array $select = [], array $filter = [])
	{
		$sql = 'select ';
		$prepare = [];

		if ($select)
		{
			$countSelect = count($select);
			$counter = 0;
			foreach ($select as $alias => $column)
			{
				$counter++;
				if (!is_numeric($alias))
				{
					$sql .= " ${column} as ${alias} ";
				}
				else
				{
					$sql .=  " ${column} ";
				}

				if ($counter != $countSelect)
				{
					$sql .= ', ';
				}
			}
		}
		else
		{
			$sql .= "*";
		}

		$sql .= " from " . static::getTableName();

		if ($join = static::getJoinInfo())
		{
			$currentTable = static::getTableName();

			$sql .= " join ${join['table']} on ${join['table']}.${join['remote_key']} = ${currentTable}.${join['this_key']}";
		}

		if ($filter)
		{
			$sql .= " where ";

			foreach ($filter as $column => $value)
			{
				$temp = static::getAlias($column);

				$prepare[$temp] = $value;

				$sql .= "${column} = ${temp}";
			}
		}

		return static::exec($sql, $prepare);
	}

	public static function update(int $id, array $values): ?PDOStatement
	{
		$sql = "update " . static::getTableName() . " set ";
		$prepare = [];

		$countSelect = count($values);
		$counter = 0;
		foreach ($values as $column => $value)
		{
			$counter++;
			$temp = static::getAlias($column);

			$prepare[$temp] = $value;

			$sql .= "${column} = ${temp}";

			if ($counter != $countSelect)
			{
				$sql .= ', ';
			}
		}

		$sql .= " where id = :id";
		$prepare[":id"] = $id;

		return static::exec($sql, $prepare);
	}

	public static function delete(int $id): ?PDOStatement
	{
		$sql = 'delete from ' . static::getTableName() . ' where id = :id';

		return static::exec($sql, [':id' => $id]);
	}

	/**
	 * @param string $column
	 * @return string
	 */
	protected static function getAlias(string $column): string
	{
		return ':' . str_replace('.', '_', $column);
	}

	/**
	 * @param string $sql
	 * @param array $prepare
	 * @return ?PDOStatement
	 */
	public static function exec(string $sql, array $prepare): ?PDOStatement
	{
		foreach ($prepare as &$item)
		{
			$item = htmlspecialchars(trim($item));
		}

		$ob = DB::getInstance()->getConnection()->prepare($sql);

		$ob->execute($prepare);

		return $ob;
	}

}
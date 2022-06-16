<?php

namespace App\Tables;

use App\DataBase\DB;
use App\DTO\Client;
use PDOStatement;

class ClientsTable extends \App\BaseTable
{
	public static function getTableName(): string
	{
		return 'clients';
	}

	protected static function getJoinInfo(): array
	{
		return [];
	}

	public static function getDTO(array $select = [], array $filter = []): array
	{
		$result = [];

		$ob = parent::get(['id', 'name'], $filter, ['name' => 'ASC']);

		while ($itm = $ob->fetch(\PDO::FETCH_ASSOC))
		{
			$result[] = new Client($itm['id'], $itm['name']);
		}

		return $result;
	}

	public static function getLastItem(): Client
	{
		$sql = 'select id, name from clients order by id desc limit 1';

		$ob = DB::getInstance()->getConnection()->query($sql)->fetch(\PDO::FETCH_ASSOC);

		return new Client($ob['id'], $ob['name']);
	}
}
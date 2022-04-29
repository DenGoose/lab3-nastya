<?php

namespace App\Tables;

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
}
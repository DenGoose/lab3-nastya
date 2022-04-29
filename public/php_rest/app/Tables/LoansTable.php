<?php

namespace App\Tables;

class LoansTable extends \App\BaseTable
{
	public static function getTableName(): string
	{
		return 'loans';
	}

	protected static function getJoinInfo(): array
	{
		return [
			'table' => ClientsTable::getTableName(),
			'this_key' => 'id_client',
			'remote_key' => 'id'
		];
	}
}
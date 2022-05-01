<?php

namespace App\Tables;

use App\DataBase\DB;
use App\DTO\Client;
use App\DTO\Loan;

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

	/**
	 * @param array $select
	 * @param array $filter
	 * @return array<Loan>
	 */
	public static function getDTO(array $select = [], array $filter = []): array
	{
		$result = [];

		$ob = static::get(
			[
				'LOANS_ID' => 'loans.id',
				'LOANS_PHOTO' => 'loans.photo',
				'LOANS_LOAN_PURPOSE' => 'loans.loan_purpose',
				'LOANS_MANAGER_COMMENT' => 'loans.manager_comment',
				'LOANS_LOAN_AMOUNT' => 'loans.loan_amount',
				'CLIENTS_ID' => 'clients.id',
				'CLIENTS_NAME' => 'clients.name'
			],
			$filter
		);

		while ($itm = $ob->fetch(\PDO::FETCH_ASSOC))
		{
			$result[] = new Loan(
				$itm['LOANS_ID'],
				$itm['LOANS_PHOTO'],
				$itm['LOANS_LOAN_PURPOSE'],
				$itm['LOANS_MANAGER_COMMENT'],
				$itm['LOANS_LOAN_AMOUNT'],
				new Client($itm['CLIENTS_ID'], $itm['CLIENTS_NAME'])
			);
		}

		return $result;
	}

	public static function getLastItem(): Loan
	{
		$sql = 'select loans.id, loans.photo, loans.loan_purpose, loans.manager_comment, loans.loan_amount, clients.id as clients_id, clients.name as clients_name from loans ';
		$sql .= 'join clients on clients.id = loans.id_client ';
		$sql .= 'order by id desc limit 1';

		$ob = DB::getInstance()->getConnection()->query($sql)->fetch(\PDO::FETCH_ASSOC);

		return new Loan(
			$ob['id'],
			$ob['photo'],
			$ob['loan_purpose'],
			$ob['manager_comment'],
			$ob['loan_amount'],
			new Client($ob['clients_id'], $ob['clients_name'])
		);
	}
}
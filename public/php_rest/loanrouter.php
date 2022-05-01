<?php

use App\Tables\ClientsTable;
use App\Tables\LoansTable;
use Silex\Application;

/**
 * @param Application $app
 * @return void
 */
function getLoans(Application $app, $json): void
{
	$app->get('/rest/loans/get-list.json', function() use ($app, $json)
	{
		try
		{
			$filter = [
				'loans.id' => $_GET['filter']['id'] ?? 0
			];

			$result = LoansTable::getDTO(
				[
					'LOANS_ID' => 'loans.id',
					'LOANS_PHOTO' => 'loans.photo',
					'LOANS_LOAN_PURPOSE' => 'loans.loan_purpose',
					'LOANS_MANAGER_COMMENT' => 'loans.manager_comment',
					'LOANS_LOAN_AMOUNT' => 'loans.loan_amount',
					'CLIENTS_ID' => 'clients.id',
					'CLIENTS_NAME' => 'clients.name'
				],
				$filter['loans.id'] ? $filter : []
			);

			return $app->json($result);
		} catch (Throwable $e)
		{
			return $app->json([
				'error' => true,
				'error_message' => $e->getMessage()
			])->setStatusCode(500);
		}
	});
}

/**
 * @param Application $app
 * @return void
 */
function addLoan(Application $app, $json): void
{
	$app->post('/rest/loans/add.json', function() use ($app, $json)
	{
		try
		{
			if (
				!mb_strlen(trim($json['photo'])) ||
				!mb_strlen(trim($json['loan_purpose'])) ||
				!mb_strlen(trim($json['manager_comment'])) ||
				(!mb_strlen(trim($json['loan_amount'])) || !intval($json['loan_amount'])) ||
				(!mb_strlen(trim($json['сlient']['id'])) || !intval($json['сlient']['id']))
			)
			{
				return $app->json([
					'error' => true,
					'error_message' => "Не все поля заполнены"
				])->setStatusCode(404);
			}

			LoansTable::add([
				'photo' => $json['photo'],
				'loan_purpose' => $json['loan_purpose'],
				'manager_comment' => $json['manager_comment'],
				'loan_amount' => $json['loan_amount'],
				'id_client' => intval($json['сlient']['id']),
			]);


			return $app->json([
				'items' => LoansTable::getLastItem(),
				'error' => [
					'error' => false,
					'error_message' => '',
				]
			]);
		} catch (Throwable $e)
		{
			return $app->json([
				'error' => true,
				'error_message' => $e->getMessage()
			])->setStatusCode(500);
		}
	});
}

/**
 * @param Application $app
 * @return void
 */
function deleteLoan(Application $app, $json): void
{
	$app->post('/rest/loans/delete.json', function() use ($app, $json)
	{
		try
		{
			if (!mb_strlen(trim($json['id'])))
			{
				return $app->json([
					'error' => true,
					'error_message' => "Пустой id"
				])->setStatusCode(404);
			}

			$data = LoansTable::get(
				['ID' => 'loans.id'],
				[
					'loans.id' => $json['id']
				]
			);

			if (!isset($data->fetch(PDO::FETCH_ASSOC)['ID']))
			{
				return $app->json([
					'error' => true,
					'error_message' => "Такого займа не существует"
				])->setStatusCode(404);
			}

			LoansTable::delete(intval($json['id']));

			return $app->json([
				'error' => false,
				'error_message' => ''
			]);
		} catch (Throwable $e)
		{
			return $app->json([
				'error' => true,
				'error_message' => $e->getMessage()
			])->setStatusCode(500);
		}
	});
}


/**
 * @param Application $app
 * @return void
 */
function updateLoan(Application $app, $json): void
{
	$app->post('/rest/loans/update.json', function() use ($app, $json)
	{
		try
		{
			if (
				!mb_strlen(trim($json['photo'])) &&
				!mb_strlen(trim($json['loan_purpose'])) &&
				!mb_strlen(trim($json['manager_comment'])) &&
				(!mb_strlen(trim($json['loan_amount'])) || !intval($json['loan_amount'])) &&
				(!mb_strlen(trim($json['client']['id'])) || !intval($json['client']['id']))
			)
			{
				return $app->json([
					'error' => true,
					'error_message' => "Не все поля заполнены"
				])->setStatusCode(404);
			}

			LoansTable::update($json['id'], [
				'photo' => $json['photo'],
				'loan_purpose' => $json['loan_purpose'],
				'manager_comment' => $json['manager_comment'],
				'loan_amount' => $json['loan_amount'],
				'id_client' => intval($json['client']['id'])
			]);

			return $app->json([
				'item' => LoansTable::getLastItem(),
				'error' => [
					'error' => false,
					'error_message' => ''
				]
			]);
		} catch (Throwable $e)
		{
			return $app->json([
				'error' => true,
				'error_message' => $e->getMessage()
			])->setStatusCode(500);
		}
	});
}

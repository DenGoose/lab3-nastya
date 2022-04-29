<?php

use App\Tables\ClientsTable;
use App\Tables\LoansTable;

if ($_SERVER['REQUEST_URI'] == '/')
{
	include 'index.html';
} elseif (stristr($_SERVER['REQUEST_URI'], '/rest/'))
{
	require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

	if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/files'))
	{
		mkdir($_SERVER['DOCUMENT_ROOT'] . '/files');
	}

	$app = new Silex\Application();

	/**
	 * php://input является потоком только для чтения, который позволяет вам читать необработанные данные из тела запроса.
	 */
	$json = json_decode(file_get_contents('php://input'), true);

	$app->get('/rest/clients/get-list.json', function() use ($app, $json)
	{
		try
		{
			$data = ClientsTable::get(
				[
					'id', 'name'
				],
				$_GET['filter'] ?? []
			);

			return $app->json($data->fetchAll(PDO::FETCH_ASSOC));
		} catch (Throwable $e)
		{
			return $app->json([
				'error' => true,
				'error_message' => $e->getMessage()
			])->setStatusCode(500);
		}
	});

	$app->post('/rest/clients/add.json', function() use ($app, $json)
	{
		try
		{
			if (!mb_strlen(trim($json['name'])))
			{
				return $app->json([
					'error' => true,
					'error_message' => "Не все поля заполнены"
				])->setStatusCode(409);
			}

			$data = ClientsTable::get(
				['name'],
				[
					'name' => $json['name']
				]
			);

			if (isset($data->fetch(PDO::FETCH_ASSOC)['name']))
			{
				return $app->json([
					'error' => true,
					'error_message' => "Такой клиент уже существует"
				])->setStatusCode(409);
			}

			ClientsTable::add(['name' => $json['name']]);

			$id = ClientsTable::getLastId();

			return $app->json([
				'error' => false,
				'error_message' => '',
				'id' => $id
			]);
		} catch (Throwable $e)
		{
			return $app->json([
				'error' => true,
				'error_message' => $e->getMessage()
			])->setStatusCode(500);
		}
	});

	$app->post('/rest/clients/delete.json', function() use ($app, $json)
	{
		try
		{
			if (!mb_strlen(trim($json['id'])))
			{
				return $app->json([
					'error' => true,
					'error_message' => "Пустой id"
				])->setStatusCode(409);
			}

			$data = ClientsTable::get(
				['id'],
				[
					'id' => $json['id']
				]
			);

			if (!isset($data->fetch(PDO::FETCH_ASSOC)['id']))
			{
				return $app->json([
					'error' => true,
					'error_message' => "Такого клиента не существует"
				])->setStatusCode(409);
			}

			ClientsTable::delete(intval($json['id']));

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

	$app->post('/rest/clients/update.json', function() use ($app, $json)
	{
		try
		{
			if (!mb_strlen(trim($json['id'])) && !mb_strlen(trim($json['name'])))
			{
				return $app->json([
					'error' => true,
					'error_message' => "Пустые данные"
				])->setStatusCode(409);
			}

			ClientsTable::update(
				$json['id'],
				['name' => $json['name']]
			);

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

	$app->get('/rest/loans/get-list.json', function() use ($app, $json)
	{
		try
		{
			$data = LoansTable::get(
				[
					'LOANS_ID' => 'loans.id',
					'LOANS_PHOTO' => 'loans.photo',
					'LOANS_LOAN_PURPOSE' => 'loans.loan_purpose',
					'LOANS_MANAGER_COMMENT' => 'loans.manager_comment',
					'LOANS_LOAN_AMOUNT' => 'loans.loan_amount',
					'CLIENTS_ID' => 'clients.id',
					'CLIENTS_NAME' => 'clients.name'
				],
				$_GET['filter'] ?? []
			);

			$result = [];

			while ($itm = $data->fetch(PDO::FETCH_ASSOC))
			{
				$result[] = [
					'id' => $itm['LOANS_ID'],
					'photo' => $itm['LOANS_PHOTO'],
					'loan_purpose' => $itm['LOANS_LOAN_PURPOSE'],
					'manager_comment' => $itm['LOANS_MANAGER_COMMENT'],
					'loan_amount' => $itm['LOANS_LOAN_AMOUNT'],
					'Client' => [
						'id' => $itm['CLIENTS_ID'],
						'name' => $itm['CLIENTS_NAME']
					]
				];
			}

			return $app->json($result);
		} catch (Throwable $e)
		{
			return $app->json([
				'error' => true,
				'error_message' => $e->getMessage()
			])->setStatusCode(500);
		}
	});

	$app->post('/rest/loans/add.json', function() use ($app, $json)
	{
		try
		{
			if (
				!mb_strlen(trim($json['photo'])) ||
				!mb_strlen(trim($json['loan_purpose'])) ||
				!mb_strlen(trim($json['manager_comment'])) ||
				(!mb_strlen(trim($json['loan_amount'])) || !intval($json['loan_amount'])) ||
				(!mb_strlen(trim($json['Client']['id'])) || !intval($json['Client']['id']))
			)
			{
				return $app->json([
					'error' => true,
					'error_message' => "Не все поля заполнены"
				])->setStatusCode(409);
			}

			LoansTable::add([
				'photo' => $json['photo'],
				'loan_purpose' => $json['loan_purpose'],
				'manager_comment' => $json['manager_comment'],
				'loan_amount' => $json['loan_amount'],
				'id_client' => $json['Client']['id'],
			]);

			$id = LoansTable::getLastId();

			return $app->json([
				'error' => false,
				'error_message' => '',
				'id' => $id
			]);
		} catch (Throwable $e)
		{
			return $app->json([
				'error' => true,
				'error_message' => $e->getMessage()
			])->setStatusCode(500);
		}
	});

	$app->post('/rest/loans/delete.json', function() use ($app, $json)
	{
		try
		{
			if (!mb_strlen(trim($json['id'])))
			{
				return $app->json([
					'error' => true,
					'error_message' => "Пустой id"
				])->setStatusCode(409);
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
				])->setStatusCode(409);
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

	$app->post('/rest/loans/update.json', function() use ($app, $json)
	{
		try
		{
			if (
				!mb_strlen(trim($json['photo'])) &&
				!mb_strlen(trim($json['loan_purpose'])) &&
				!mb_strlen(trim($json['manager_comment'])) &&
				(!mb_strlen(trim($json['loan_amount'])) || !intval($json['loan_amount'])) &&
				(!mb_strlen(trim($json['Client']['id'])) || !intval($json['Client']['id']))
			)
			{
				return $app->json([
					'error' => true,
					'error_message' => "Не все поля заполнены"
				])->setStatusCode(409);
			}

			LoansTable::update($json['id'], [
				'photo' => $json['photo'],
				'loan_purpose' => $json['loan_purpose'],
				'manager_comment' => $json['manager_comment'],
				'loan_amount' => $json['loan_amount'],
				'id_client' => intval($json['Client']['id'])
			]);

			return $app->json([
				'error' => false,
				'error_message' => ''
			]);
		} catch (Throwable $e)
		{
			return $app->json([
				'error' => true,
				'error_message' => $e->getMessage() . "\nLine: " . $e->getLine()
			])->setStatusCode(500);
		}
	});

	$app->post('/rest/file/upload', function() use ($app)
	{
		$filePath = '/files/' . $_FILES['file']['name'];

		if (mb_strlen($_FILES['file']['name']) && move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $filePath))
		{
			return $app->json([
				'error' => false,
				'error_message' => '',
				'file_path' => $filePath,
				'full_file_path' => "http://" . $_SERVER['HTTP_HOST'] . $filePath
			]);
		}

		return $app->json([
			'error' => true,
			'error_message' => 'Ошибка загрузки файла'
		])->setStatusCode(404);
	});

	$app->run();
}
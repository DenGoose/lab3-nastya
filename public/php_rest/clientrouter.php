<?php

use App\Tables\ClientsTable;
use Silex\Application;

/**
 * @param Application $app
 * @return void
 */
function getClients(Application $app, $json): void
{
	$app->get('/rest/clients/get-list.json', function() use ($app, $json)
	{
		try
		{
			$data = ClientsTable::getDTO(
				[
					'id', 'name'
				],
				$_GET['filter'] ?? []
			);

			return $app->json($data);
		} catch (Throwable $e)
		{
			return $app->json([
				'error' => [
					'error' => true,
					'error_message' => $e->getMessage()
				]
			])->setStatusCode(500);
		}
	});
}

/**
 * @param Application $app
 * @return void
 */
function addClient(Application $app, $json): void
{
	$app->post('/rest/clients/add.json', function() use ($app, $json)
	{
		try
		{
			if (!mb_strlen(trim($json['name'])))
			{
				return $app->json([
					'error' => [
						'error' => true,
						'error_message' => "Не все поля заполнены"
					]
				])->setStatusCode(400);
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
					'error' => [
						'error' => true,
						'error_message' => "Такой клиент уже существует"
					]
				])->setStatusCode(400);
			}

			ClientsTable::add(['name' => $json['name']]);

			$lestItem = ClientsTable::getLastItem();


			return $app->json([
				'item' => $lestItem,
				'error' => [
					'error' => false,
					'error_message' => ''
				]
			]);
		} catch (Throwable $e)
		{
			return $app->json([
				'error' => [
					'error' => true,
					'error_message' => $e->getMessage()
				]
			])->setStatusCode(500);
		}
	});
}


/**
 * @param Application $app
 * @return void
 */
function deleteClient(Application $app, $json): void
{
	$app->post('/rest/clients/delete.json', function() use ($app, $json)
	{
		try
		{
			if (!mb_strlen(trim($json['id'])))
			{
				return $app->json([
					'error' => [
						'error' => true,
						'error_message' => "Пустой id"
					]
				])->setStatusCode(400);
			}

			$data = ClientsTable::get(
				['id'],
				[
					'id' => $json['id']
				]
			);

			if (!isset($data->fetch(PDO::FETCH_ASSOC)['id']))
			{
				$clientId = $json['id'];

				return $app->json([
					'error' => [
						'error' => true,
						'error_message' => "Клиент c id = ${clientId} не существует"
					]
				])->setStatusCode(400);
			}

			ClientsTable::delete(intval($json['id']));

			return $app->json([
				'error' => [
					'error' => false,
					'error_message' => ''
				]
			]);
		} catch (Throwable $e)
		{
			return $app->json([
				'error' => [
					'error' => true,
					'error_message' => $e->getMessage()
				]
			])->setStatusCode(500);
		}
	});
}

/**
 * @param Application $app
 * @return void
 */
function updateClient(Application $app, $json): void
{
	$app->post('/rest/clients/update.json', function() use ($app, $json)
	{
		try
		{
			if (!mb_strlen(trim($json['id'])) && !mb_strlen(trim($json['name'])))
			{
				return $app->json([
					'error' => [
						'error' => true,
						'error_message' => "Пустые данные"
					]
				])->setStatusCode(400);
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
					'error' => [
						'error' => true,
						'error_message' => "Вы пытаетесь изменить имя на существующего пользователя"
					]
				])->setStatusCode(400);
			}

			ClientsTable::update(
				$json['id'],
				['name' => $json['name']]
			);

			return $app->json([
				'item' => ClientsTable::getLastItem(),
				'error' => [
					'error' => false,
					'error_message' => ''
				]
			]);
		} catch (Throwable $e)
		{
			return $app->json([
				'error' => [
					'error' => true,
					'error_message' => $e->getMessage()
				]
			])->setStatusCode(500);
		}
	});
}
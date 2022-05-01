<?php

use App\Tables\ClientsTable;
use App\Tables\LoansTable;

if (!stristr($_SERVER['REQUEST_URI'], '/rest/'))
{
	include 'index.html';
}
else
{
	require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

	// Вынесла методы в отдельный файл
	require_once 'php_rest/clientrouter.php';
	require_once 'php_rest/loanrouter.php';

	// Проверка на существование папки для файлов
	if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/files'))
	{
		mkdir($_SERVER['DOCUMENT_ROOT'] . '/files');
	}

	$app = new Silex\Application();

	/**
	 * php://input является потоком только для чтения, который позволяет вам читать необработанные данные из тела запроса.
	 */
	$json = json_decode(file_get_contents('php://input'), true);

	// Методы с Клиентами
	getClients($app, $json);
	addClient($app, $json);
	deleteClient($app, $json);
	updateClient($app, $json);
	// Методы с Займами
	getLoans($app, $json);
	addLoan($app, $json);
	deleteLoan($app, $json);
	updateLoan($app, $json);


	// Метод для сохранения файла
	$app->post('/rest/file/upload', function() use ($app)
	{
		$filePath = '/files/' . $_FILES['file']['name'];

		if (mb_strlen($_FILES['file']['name']) && move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $filePath))
		{
			return $app->json([
				'item' => [
					'file_path' => $filePath,
					'full_file_path' => "http://" . $_SERVER['HTTP_HOST'] . $filePath
				],
				'error' => [
					'error' => false,
					'error_message' => ''
				]
			]);
		}

		return $app->json([
			'error' => [
				'error' => true,
				'error_message' => 'Ошибка загрузки файла'
			]
		])->setStatusCode(404);
	});

	$app->run();
}
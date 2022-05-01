<?php
error_reporting(null);
ini_set('display_errors', 0);
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
	require_once 'php_rest/filerouter.php';

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
	uploadFile($app);

	$app->run();
}
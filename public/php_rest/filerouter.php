<?php

use Silex\Application;

/**
 * @param Application $app
 * @return void
 */
function uploadFile(Application $app): void
{
	$app->post('/rest/file/upload', function() use ($app)
	{
		if (!isset($_FILES['file']['name']))
		{
			return $app->json([
				'error' => [
					'error' => true,
					'error_message' => 'Файл не был отправлен'
				]
			])->setStatusCode(400);
		}

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
}
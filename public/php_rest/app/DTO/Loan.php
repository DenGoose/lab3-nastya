<?php

namespace App\DTO;

class Loan
{
	/** @var int ID пользователя */
	public int $id;
	/** @var string Путь до фотографии относительно корня сайта */
	public string $photo;
	/** @var string Цель кредита */
	public string $loan_purpose;
	/** @var string Комментарий менеджера */
	public string $manager_comment;
	/** @var int Сумма кредита */
	public int $loan_amount;
	/** @var Client Клиент */
	public Client $client;

	public function __construct(
		?int $id = null,
		?string $photo = null,
		?string $loan_purpose = null,
		?string $manager_comment = null,
		?int $loan_amount = null,
		?Client $client = null
	)
	{
		$this->id = $id;
		$this->photo = $photo;
		$this->loan_purpose = $loan_purpose;
		$this->manager_comment = $manager_comment;
		$this->loan_amount = $loan_amount;
		$this->client = $client;
	}
}
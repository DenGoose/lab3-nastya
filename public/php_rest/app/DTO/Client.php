<?php

namespace App\DTO;

class Client
{
	/** @var int ID пользователя */
	public int $id;
	/** @var string Имя */
	public string $name;

	public function __construct(
		?int $id = null,
		?string $name = null,
	)
	{
		$this->id = $id;
		$this->name = $name;
	}
}
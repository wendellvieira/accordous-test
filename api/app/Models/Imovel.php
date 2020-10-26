<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imovel extends Model
{
	protected $table = "imoveis";

	protected $fillable = [
		"email",
		"cep",
		"bairro",
		"localidade",
		"logradouro",
		"numero",
		"uf",
		"complemento"
	];
}

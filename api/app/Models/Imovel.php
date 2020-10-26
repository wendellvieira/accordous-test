<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imovel extends Model
{
	use SoftDeletes;

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

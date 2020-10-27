<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $fillable = [
		"nome",
		"email",
		"tipo_documento",
		"documento",
		"propriedade"
	];

	public function propriedade(){
		return $this->belongsTo( Imovel::class, "propriedade" );
	}
}

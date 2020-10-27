<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Contrato;

class ContratosController extends Controller
{
	//
	public function create( Request $data ){
		$contrato = Contrato::create( $data->toArray() );
		return $contrato;
	}

	public function index(){
		return Contrato::with(['propriedade'])->get();
	}
}

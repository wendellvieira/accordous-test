<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Imovel;

class ImoveisController extends Controller
{
    public function create( Request $data ){
		$imovel = Imovel::create( $data->toArray() );
		return $imovel;
	}

	public function index(){
		return Imovel::with(["contrato"])->get();
	}

	public function delete($id){
		$imovel = Imovel::findOrFail($id);

		return $imovel->delete();
	}
}

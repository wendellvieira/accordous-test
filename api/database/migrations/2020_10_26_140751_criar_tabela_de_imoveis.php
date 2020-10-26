<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaDeImoveis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imoveis', function (Blueprint $table) {
			$table->id();

			$table->string('email');

			$table->string('cep', 9);
			$table->string('bairro');
			$table->string('localidade');
			$table->string('logradouro');
			$table->string('numero');
			$table->string('uf', 2);

			$table->string('complemento')->nullable();

			$table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imoveis');
    }
}

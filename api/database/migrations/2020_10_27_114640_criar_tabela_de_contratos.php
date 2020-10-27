<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaDeContratos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
			$table->id();

			$table->string('nome');
			$table->string('email');
			$table->enum('tipo_documento', ["cpf", "cnpj"]);
			$table->string('documento', 18);

			$table->unsignedBigInteger('propriedade')
				->unique();
			$table->foreign('propriedade')
				->references('id')
				->on('imoveis');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contratos');
    }
}

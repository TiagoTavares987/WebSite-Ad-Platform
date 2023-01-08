<?php

use App\Database\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anuncios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('imageId')->nullable();
            $table->unsignedBigInteger('vendedorId');
            $table->string('nome');
            $table->string('descricao');
            $table->float('preco');
            $table->float('quantidade');
            $table->boolean('apagado')->default(false);
            $table->timestamps();
        });

        if(Schema::hasTable('photos'))
            Schema::table('anuncios', function(Blueprint $table)
            {
                $table->foreign('imageId')->references('id')->on('photos');            
            });

        if(Schema::hasTable('users'))
            Schema::table('anuncios', function(Blueprint $table)
            {  
                $table->foreign('vendedorId')->references('id')->on('users');          
            });

        if(Schema::hasTable('compras'))
            Schema::table('compras', function(Blueprint $table)
            {
                $table->foreign('anuncioId')->references('id')->on('anuncios');            
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::DisableForeignKeys();
        
        Schema::dropIfExists('anuncios');

        DB::EnableForeignKeys();
    }
};

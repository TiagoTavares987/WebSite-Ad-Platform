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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compradorId');
            $table->unsignedBigInteger('anuncioId');
            $table->float('preco');
            $table->float('quantidade');
            $table->timestamps();
        });

        if(Schema::hasTable('users'))
            Schema::table('compras', function(Blueprint $table)
            {
                $table->foreign('compradorId')->references('id')->on('users');            
            });

        if(Schema::hasTable('anuncios'))
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
        
        Schema::dropIfExists('compras');

        DB::EnableForeignKeys();
    }
};

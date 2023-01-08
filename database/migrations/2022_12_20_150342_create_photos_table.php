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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('path');
            $table->timestamps();
        });

        if(Schema::hasTable('users'))
            Schema::table('users', function(Blueprint $table)
            {
                $table->foreign('imageId')->references('id')->on('photos');            
            });

        if(Schema::hasTable('anuncios'))
            Schema::table('anuncios', function(Blueprint $table)
            {
                $table->foreign('imageId')->references('id')->on('photos');        
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

        Schema::dropIfExists('photos');

        DB::EnableForeignKeys();
    }
};

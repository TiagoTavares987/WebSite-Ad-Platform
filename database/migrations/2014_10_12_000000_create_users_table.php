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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('primeiroNome');
            $table->string('ultimoNome');
            $table->string('contacto');
            $table->string('nif');
            $table->unsignedBigInteger('imageId')->nullable();            
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('bloqueado')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        if(Schema::hasTable('photos'))
            Schema::table('users', function(Blueprint $table)
            {
                $table->foreign('imageId')->references('id')->on('photos');            
            });

        if(Schema::hasTable('anuncios'))
            Schema::table('anuncios', function(Blueprint $table)
            {  
                $table->foreign('vendedorId')->references('id')->on('users');          
            });

        if(Schema::hasTable('compras'))
            Schema::table('compras', function(Blueprint $table)
            {
                $table->foreign('compradorId')->references('id')->on('users');            
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
        
        Schema::dropIfExists('users');

        DB::EnableForeignKeys();
    }
};

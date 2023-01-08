<?php

namespace App\Database;

class DB
{
    public static function DisableForeignKeys()
    {
        if(env("DB_CONNECTION") == "mysql")
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if(env("DB_CONNECTION") == "pgsql")
            \Illuminate\Support\Facades\DB::statement('SET session_replication_role = \'replica\';');
    }    

    public static function EnableForeignKeys()
    {
        if(env("DB_CONNECTION") == "mysql")
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        if(env("DB_CONNECTION") == "pgsql")
            \Illuminate\Support\Facades\DB::statement('SET session_replication_role = \'origin\';');
    } 
}
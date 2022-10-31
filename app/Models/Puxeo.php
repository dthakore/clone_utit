<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Puxeo extends Model
{
    use HasFactory;

    protected $connection = 'puxeo';

    protected $table = 'tenants';

    protected $guarded = [];

    public function configure(){
        config([
            'database.connections.mysql.database' => $this->database,
        ]);

        DB::purge('mysql');

        DB::reconnect('mysql');

        Schema::connection('mysql')->getConnection()->reconnect();

        return $this;
    }

    public function use(){
        app()->forgetInstance('mysql');

        app()->instance('mysql', $this);

        return $this;
    }
}

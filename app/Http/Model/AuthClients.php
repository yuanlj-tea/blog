<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class AuthClients extends Model
{
    protected $table = 'auth_clients';

    protected $primaryKey = 'ID';

    public $timestamps = false;
}

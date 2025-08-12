<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Smtp extends Model
{
    protected $fillable = [
        'mailer', 'host', 'port', 'username', 'password', 'encryption',
        'from_address', 'from_name', 'limit'
    ];
}

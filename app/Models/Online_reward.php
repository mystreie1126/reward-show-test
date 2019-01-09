<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Online_reward extends Model
{
    protected $table = 'ps_rewards';
    protected $primaryKey = 'id_reward';
    public $timestamps = false;
}

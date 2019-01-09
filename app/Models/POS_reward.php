<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class POS_reward extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'ps_rewards';
  protected $primaryKey = 'id_reward';
  public $timestamps = false;
}

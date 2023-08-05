<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class references extends Model
{
    use HasFactory;
    protected $table = 'referencias';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
}

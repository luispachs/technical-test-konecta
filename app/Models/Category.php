<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categoria';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;


    public static function getAll(){
        return DB::table( 'categoria')->get();
    }

}

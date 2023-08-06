<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    public static function getAll(){
        return DB::table( 'productos')->get();
    }
    public function infoCategory(){
        return $this->hasOne(Category::class,'id','categoria');
    }

}

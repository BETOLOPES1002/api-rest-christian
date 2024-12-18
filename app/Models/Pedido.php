<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable =['users_id','total','fechapedido'];

    public function usuario(){
        return $this->belongsTo(User::class);
    }

    public function productos(){
        return $this ->belongsToMany(Producto::class,'detallepedido')
        ->withPivot('cantidad','precio')
        ->withTimestamps();

    }
}


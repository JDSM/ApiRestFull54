<?php

namespace App;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
    /**
     * bloque que solucina la comunicacion entre
     * las relacion de muchos a muchos
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}

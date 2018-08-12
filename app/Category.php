<?php

namespace App;
use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
    ];

    //excluye de los resultados el atributo pivot

    protected $hidden = [
        'pivot'
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

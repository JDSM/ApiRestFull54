<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *Obtiene la lista de compradores de una categoria
     *se debe juntar todas las colecciones de transaction
     *con collapse y depues obtener con pluck solo los compradores
     *  @return \Illuminate\Http\Response
     */

    public function index(Category $category)
    {
        $buyers = $category->products()
        ->whereHas('transactions')
        ->with('transactions.buyer')
        ->get()
        ->pluck('transactions')
        ->collapse()
        ->pluck('buyer')
        ->unique()
        ->values() ;

        return $this->showAll($buyers);
    }
}

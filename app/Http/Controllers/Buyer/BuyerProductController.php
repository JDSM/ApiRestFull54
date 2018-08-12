<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     * lista de producto de un comprador 
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $products = $buyer
        ->transactions()
        ->with('product')
        ->get()
        ->pluck('product');

        //dd($products);

        return $this->showAll($products);
    }
}
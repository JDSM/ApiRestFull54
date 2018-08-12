<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        /**
         * este bloque busca la relacion que existe entre buyer y seller
         * determina cuales son los productos comprados a un vendedor
         * Eager Loading realiza una busqueda por medio del metodo with
         * seleccionando con pluck unicamente la lista de vendedores
         * ingresando primero a product y luego a seller
         * con unique evita que los vendedores se repitan
         * values reorganiza la coleccion ya que al no repetir los vendedores 
         * quedan espacios en blancos 
         */
        $sellers = $buyer
            ->transactions()
            ->with('product.seller')
            ->get()
            ->pluck('product.seller')
            ->unique('id')
            ->values();
        //dd($seller);
        return $this->showAll($sellers);
    }
}

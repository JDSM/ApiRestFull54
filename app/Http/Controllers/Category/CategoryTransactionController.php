<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *Obtiene la lista de transacciones que se han realizado para una categoria
     * @return \Illuminate\Http\Response
     */
    //whereHas trae los productos que tienen por lomenos 1 transaction 
    public function index(Category $category)
    {
        $transactions = $category
        ->products()
        ->whereHas('transactions')
        ->with('transactions')
        ->get()
        ->pluck('transactions')
        ->collapse();

        return $this->showAll($transactions);
    }
}

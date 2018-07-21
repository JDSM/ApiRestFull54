<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Buyer;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compradores = Buyer::has('transactions')->get();

        return response()->json(['data' => $compradores], 200);
    }

    public function show($id)
    {
        $compradores = Buyer::has('transactions')->findOrFail($id);

        return response()->json(['data' => $compradores], 200);
    }
}

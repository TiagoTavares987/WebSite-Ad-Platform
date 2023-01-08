<?php

namespace App\Http\Controllers\Relatorio;


use App\Models\Anuncio;
use App\Models\Compra;
use App\Http\Controllers\Base\Controller;
use App\Providers\RouteServiceProvider;

class RelatorioController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;
    
    public function __construct()
    {
        $this->middleware(['auth', 'isBlocked', 'verified']);
    }  

    public function ads()
    {
        $list = Anuncio::select('anuncios.*')
            ->selectRaw('(anuncios.quantidade - sum(compras.quantidade)) as disponivel')
            //->selectRaw('anuncios.quantidade - sum(ISNULL(compras.quantidade,0))) as disponivel')
            ->leftJoin('compras', 'anuncios.id', '=', 'compras.anuncioId')
            ->where('anuncios.vendedorId', auth()->user()->id)
            ->groupBy('anuncios.id')
            ->get();

        return view('report.ads', ['ads' => $list]);
    }

    public function sales()
    {
        $list = Compra::select('compras.*', 'anuncios.nome', 'anuncios.imageId')
            ->leftJoin('anuncios', 'anuncios.id', '=', 'compras.anuncioId')
            ->where('anuncios.vendedorId', auth()->user()->id)
            ->whereNotNull('compras.id')
            ->get();

        return view('report.sales', ['sales' => $list]);
    }

    public function buys()
    {
        $list = Compra::select('compras.*', 'anuncios.nome', 'anuncios.imageId')
            ->leftJoin('anuncios', 'anuncios.id', '=', 'compras.anuncioId')
            ->where('compradorId', auth()->user()->id)
            ->get();

        return view('report.buys', ['buys' => $list]);
    }
}

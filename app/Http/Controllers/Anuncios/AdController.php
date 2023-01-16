<?php

namespace App\Http\Controllers\Anuncios;

use App\Http\Controllers\Base\Controller;
use App\Models\Anuncio;
use Illuminate\Http\Request;

class AdController extends Controller
{
    protected function getAd(Request $request)
    {
        $ad = null;

        $data = $request->all();
        if(array_key_exists('adId', $data)){
            $list = Anuncio::select('anuncios.*')->selectRaw('(anuncios.quantidade - sum(compras.quantidade)) as disponivel')
            // //->selectRaw('anuncios.quantidade - sum(ISNULL(compras.quantidade,0))) as disponivel')
            ->leftJoin('compras', 'anuncios.id', '=', 'compras.anuncioId')
            ->where('anuncios.id', $data['adId'])
            ->groupBy('anuncios.id')
            ->get();

            if($list != null && !$list->isEmpty()){
                $ad = $list[0];
            }
        }

        return $ad;
    }
}

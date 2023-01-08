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
            $list = Anuncio::where('id', $data['adId'])->get();
            if($list != null && !$list->isEmpty()){
                $ad = $list[0];
            }
        }

        return $ad;
    }
}

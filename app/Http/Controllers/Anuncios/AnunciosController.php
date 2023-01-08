<?php

namespace App\Http\Controllers\Anuncios;

use App\Models\Anuncio;
use Illuminate\Http\Request;

class AnunciosController extends AdController
{
    private const redirected = "redirected";

    public function index()
    {
        if(session()->missing(self::redirected))
            session()->put('adsConfig', (object) ['search' => (object) ['text' => null, 'searchDescription' => false], 'sort' => 0]);

        $ads = null;
        $adsConfig = session()->get('adsConfig');

        $query = Anuncio::where('apagado', false);
        if($adsConfig->search->text != null && $adsConfig->search->text != ""){
            $query = $query->where('nome', 'LIKE', '%'.$adsConfig->search->text.'%');
            if ($adsConfig->search->searchDescription) 
                $query = $query->orWhere('descricao', 'LIKE', '%'.$adsConfig->search->text.'%');
        }        
        $ads = $query->get();

        if($adsConfig->sort > 0)
        {            
            switch($adsConfig->sort)
            {
                case 1:
                    $ads = $ads->sortBy('preco');
                    break;
                    
                case 2:
                    $ads = $ads->sortByDesc('preco');
                    break;
                    
                case 3:
                    $ads = $ads->sortBy('updated_at');
                    break;
                    
                case 4:
                    $ads = $ads->sortByDesc('updated_at');
                    break;
            }
        }

        return view('ads', ['ads' => $ads, 'search' => $adsConfig->search]);
    }

    public function search(Request $request)
    {
        $data = $request->all();
        if(array_key_exists('search', $data)){
            $search = session()->get('adsConfig')->search;
            $search->text = $data['search'];
            $search->searchDescription = array_key_exists('searchDescription', $data);
        }
        session()->flash(self::redirected, self::redirected);
        return redirect()->route('ads');
    }

    public function sort(Request $request)
    {
        $data = $request->all();
        if(array_key_exists('sort', $data)){
            $adsConfig = session()->get('adsConfig');
            $adsConfig->sort = $data['sort'];
        }
        session()->flash(self::redirected, self::redirected);
        return redirect()->route('ads');
    }

    public function adView(Request $request)
    {
        $ad = $this->getAd($request);
        if($ad==null)
            return redirect()->route('ads');
        else
            return view('ad.view', ['ad' => $this->getAd($request)]);
    }
}

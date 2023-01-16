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

        $adsConfig = session()->get('adsConfig');

        $query = Anuncio::where('apagado', false);
        if($adsConfig->search->text != null && $adsConfig->search->text != ""){
            $query = $query->where('nome', 'LIKE', '%'.$adsConfig->search->text.'%');
            if ($adsConfig->search->searchDescription) 
                $query = $query->orWhere('descricao', 'LIKE', '%'.$adsConfig->search->text.'%');
        } 
        
        if($adsConfig->sort > 0)
        {            
            switch($adsConfig->sort)
            {
                case 1:
                    $query = $query->orderBy('preco');
                    break;
                    
                case 2:
                    $query = $query->orderBy('preco', 'desc');
                    break;
                    
                case 3:
                    $query = $query->orderBy('updated_at', 'desc');
                    break;
                    
                case 4:
                    $query = $query->orderBy('updated_at');
                    break;
            }
        }

        return view('ads', ['ads' => $query->paginate(9), 'search' => $adsConfig->search]);
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
        $data = $request->all();// buscar dados do formulario(o q o user picar na pagina)
        if(array_key_exists('sort', $data)){
            $adsConfig = session()->get('adsConfig'); // buscar toda a configuraçao guardada na sessao
            $adsConfig->sort = $data['sort']; // vai por a info do formulario na variavel de sessao
        }
        session()->flash(self::redirected, self::redirected); // guarda uma variavel para a proxima chamada
        return redirect()->route('ads');
    }

    public function adView(Request $request)
    {
        $ad = $this->getAd($request);
        if($ad==null)
            return redirect()->route('ads');
        else
            return view('ad.view', ['ad' => $ad]);
    }
}

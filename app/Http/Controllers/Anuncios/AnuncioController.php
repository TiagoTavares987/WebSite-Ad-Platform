<?php

namespace App\Http\Controllers\Anuncios;

use App\Http\Controllers\Base\PhotoController;
use App\Models\Anuncio;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnuncioController extends AdController
{
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'isBlocked', 'verified']);
    }       
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string', 'max:255'],
            'preco' => ['required', 'numeric', 'gt:0'],
            'quantidade' => ['required', 'numeric', 'gt:0'],
        ]);
    }

    public function edit(Request $request)
    {
        $ad = $this->getAd($request);

        $isNew = $ad == null;
        if ($isNew)
        {
            $ad = new Anuncio();
            $ad->vendedorId = auth()->user()->id;
            
            $data = $request->all();
            if (array_key_exists('nome', $data))
                $ad->nome = $data['nome'];
            if (array_key_exists('descricao', $data))
                $ad->descricao = $data['descricao'];
            if (array_key_exists('preco', $data))
                $ad->preco = $data['preco'];
            if (array_key_exists('quantidade', $data))
                $ad->quantidade = $data['quantidade'];
        }
        else if(auth()->user()->id != $ad->vendedorId && !auth()->user()->is_admin)
            return redirect()->route('ads');

        return view('ad.form', ['isNew' => $isNew, 'ad' => $ad]);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $validator=$this->validator($data);
        if($validator->fails())
            return $this->edit($request)->withErrors($validator);

        $imageId = null;
        if (array_key_exists('imageId', $data))
        {
            $imageId = PhotoController::SaveAd($request, 0);
            if($imageId == null)
                return redirect()->back()->withErrors(['error'=>'Falha na gravação da imagem']);
        }

        $ad = Anuncio::create([
            'nome' => $data['nome'],
            'descricao' => $data['descricao'],
            'preco' => $data['preco'],
            'quantidade' => $data['quantidade'],
            'vendedorId' => auth()->user()->id,
            'imageId' => $imageId,
        ]);

        if ($ad != null && $ad->id > 0)
            return redirect()->route('ad', ['adId' => $ad->id]);     
        else
            return redirect()->back()->withErrors(['error'=>'Falha na gravação do anuncio']);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $validator=$this->validator($data);
        if($validator->fails())
            return redirect()->back()->withErrors($validator);

        $ad = $this->getAd($request);

        if ($ad != null) 
        {
            $fields = [
                'nome' => $data['nome'],
                'descricao' => $data['descricao'],
                'preco' => $data['preco'],
                'quantidade' => $data['quantidade'],
                'imageId' => $ad->imageId,
            ];

            $deleteImage = null;
            if(array_key_exists('hasImage', $data))
            {
                if (array_key_exists('imageId', $data))
                {
                    $imageId = PhotoController::SaveAd($request, $ad->imageId);
                    if($imageId == null)
                        return redirect()->back()->withErrors(['error'=>'Falha na atualização da imagem']);
    
                    if($ad->imageId != $imageId)
                        $fields['imageId'] = $imageId;
                } else {
                    $fields['imageId'] = null;
                    $deleteImage = $ad->imageId;
                }
            }

            if($ad->update($fields, [])){
                if ($ad->imageId != $fields['imageId'] && $deleteImage != null)
                    PhotoController::DeleteAd($deleteImage);
                return redirect()->route('ad', ['adId' => $ad->id]);  
            }
            else if ($ad->imageId != $fields['imageId'] && $fields['imageId'] != null)
                PhotoController::DeleteAd($fields['imageId']);
        }

        return redirect()->back()->withErrors(['error'=>'Falha na atualização do anuncio']);
    }

    public function delete(Request $request)
    {
        $ad = $this->getAd($request);
        if($ad != null && (auth()->user()->id == $ad->vendedorId || auth()->user()->is_admin))
        {
            if(!$ad->update(['apagado' => true], []))
                return redirect()->back()->withErrors(['error'=>'Falha ao apagar']);
        }

        return redirect()->route('ads');
    }
}

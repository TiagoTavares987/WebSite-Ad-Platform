<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Base\Controller;
use App\Http\Controllers\Base\PhotoController;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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

    public function index()
    {
        return view('users.user', ['user' => auth()->user()]);
    }    
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'primeiroNome' => ['required', 'string', 'max:255'],
            'ultimoNome' => ['required', 'string', 'max:255'],
            'contacto' => ['required', 'string', 'max:9'],
            'nif' => ['required', 'string', 'max:9'],
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $validator=$this->validator($data);
        if($validator->fails())
            return redirect()->back()->withErrors($validator);

        $fields = [
            'primeiroNome' => $data['primeiroNome'],
            'ultimoNome' => $data['ultimoNome'],
            'contacto' => $data['contacto'],
            'nif' => $data['nif'],
            'imageId' => auth()->user()->imageId,
        ];

        if($data['password'] != null || $data['password_confirmation'] != null){
            $validator=Validator::make($data, ['password' => ['required', 'string', 'min:8', 'confirmed']]);
            if($validator->fails())
                return redirect()->back()->withErrors($validator);
            if($data['password'] != $data['password_confirmation'])
                return redirect()->back()->withErrors(['password'=>'As passwords não coincidem']);
            else
                $fields['password'] = Hash::make($data['password']);
        }

        $deleteImage = null;
        //checkbox
        if(array_key_exists('hasImage', $data))
        {
            if (array_key_exists('imageId', $data)) // ficheiro que escolhi no form
            {
                $imageId = PhotoController::SavePhoto($request, auth()->user()->imageId); // se meter novo grava
                if($imageId == null)
                    return redirect()->back()->withErrors(['error'=>'Falha na atualização da photo']);

                if(auth()->user()->imageId != $imageId)
                    $fields['imageId'] = $imageId;
            } else {
                // marca a img para apagar
                $fields['imageId'] = null;  
                $deleteImage = auth()->user()->imageId; 
            }
        }

        if(auth()->user()->update($fields, [])){
            if (auth()->user()->imageId != $fields['imageId'] && $deleteImage != null)
                PhotoController::DeletePhoto($deleteImage); // apaga a foto antiga
            return redirect()->back()->withErrors(['success'=>'Perfil atualizado']);
        }
        else  {
            if (auth()->user()->imageId != $fields['imageId'] && $fields['imageId'] != null)
                PhotoController::DeletePhoto($fields['imageId']); // apaga a foto que meteu
            return redirect()->back()->withErrors(['error'=>'Falha na atualização do perfil']);
        }
    }
}

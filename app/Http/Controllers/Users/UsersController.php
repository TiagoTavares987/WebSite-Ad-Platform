<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Base\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'isBlocked', 'verified', 'isAdmin']);
    }

    public function index()
    {
        $users = User::paginate(5);
        return view('users.users', ['users' => $users]);
    }

    public function update(Request $request)
    {
        $data = $request->all();

        if($data['id'] == auth()->user()->id)
        {
            if(array_key_exists('bloqueado', $data))
                return redirect()->back()->withErrors(['error'=>'O administrador não se pode bloquear a si']);

            if(!array_key_exists('is_admin', $data))
                return redirect()->back()->withErrors(['error'=>'O administrador não se pode retirar a si']);
        }

        $list = User::where('id', $data['id'])->get();
        
        if($list != null && !$list->isEmpty()){
            $user = $list[0];
            $fields = [
                'bloqueado' => array_key_exists('bloqueado', $data),
                'is_admin' => array_key_exists('is_admin', $data)
            ];
            
            if($user->update($fields, []))
                return redirect()->back()->withErrors(['success'=>'Utilizador atualizado']);
            else  
                return redirect()->back()->withErrors(['error'=>'Falha na atualização do utilizador']);
        }
        else{
            return redirect()->back()->withErrors(['error'=>'Erro na atualização do utilizador']);
        }
    }
}

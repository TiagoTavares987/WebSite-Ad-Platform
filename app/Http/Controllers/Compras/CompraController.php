<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Base\Controller;
use App\Models\Compra;
use App\Providers\RouteServiceProvider;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Session;
use Stripe;

class CompraController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;
    
    public function __construct()
    {
        $this->middleware(['auth', 'isBlocked', 'verified']);
    }        
    
    protected function buyValidator(array $data)
    {
        return Validator::make($data, [
            'adId' => ['required', 'string', 'max:255'],
            'price' => ['required', 'min:0.001'],
            'quantity' => ['required', 'min:0.001'],
        ]);
    }

    public function payment(Request $request)
    {
        $data = $request->all();
        if(array_key_exists("adId", $data) && array_key_exists("price", $data) && array_key_exists("quantity", $data))
        {
            $validator=$this->buyValidator($data);
            if($validator->fails())
                return redirect()->back()->withErrors($validator);

            return view('buy.payment', ["buy" => (object)["anuncioId" => $data['adId'], "preco" => $data['price'], "quantidade" => $data['quantity']]]);
        }

        return redirect()->route('dashboard');
    }  

    public function buy(Request $request)
    {
        $data = $request->all();
        if (array_key_exists("adId", $data) && array_key_exists("price", $data) && array_key_exists("quantity", $data))
        {
            /*Stripe::setApiKey(env('STRIPE_SECRET'));    

            Charge::create ([
                    "amount" => 100 * 100,
                    "currency" => "usd",
                    "source" => $request->stripeToken,
                    "description" => "Test payment from itsolutionstuff.com." 
            ]);*/

            Compra::create([
                'compradorId' => auth()->user()->id,
                'anuncioId' => $data['adId'],
                'preco' => $data['price'],
                'quantidade' => $data['quantity'],
            ]);

            return redirect()->route('report.buys');
        }

        return redirect()->route('dashboard');
    }
}

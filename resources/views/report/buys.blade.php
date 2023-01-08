@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('As minhas compras') }} 
                </div>
                @error('success')
                <div class="card-header">
                    <span style="color:green">{{ $message }}</span>
                </div>
                @enderror
                @error('error')
                <div class="card-header">
                    <span style="color:red">{{ $message }}</span>
                </div>
                @enderror
                
                <div class="card-body">
                    <table class="table">
                      <thead>
                        <tr>
                            <th scope="col">{{ __('Id') }}</th>
                            <th scope="col">{{ __('Photo') }}</th>
                            <th scope="col">{{ __('Nome') }}</th>
                            <th scope="col">{{ __('Preço') }}</th>
                            <th scope="col">{{ __('Quantidade') }}</th>
                            <th scope="col">{{ __('Data') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($buys as $buy)
                            <tr onclick="document.getElementById('adForm{{ $buy->id }}').submit()">
                                <form id='adForm{{ $buy->id }}' action="{{ route('ad') }}" method="Get">
                                    <th scope="row">
                                        {{ $buy->id }}
                                        <input name="adId" type="hidden" value="{{ $buy->anuncioId }}"/>
                                    </th>
                                    <td><img src="{{ Photo::GetAd($buy->imageId) }}" width="30" heght="30"/></td>
                                    <td>{{ $buy->nome }}</td>
                                    <td>{{ $buy->preco }}</td>
                                    <td>{{ $buy->quantidade }}</td>
                                    <td>{{ $buy->created_at }}</td>
                                </form>
                            </tr>
                        @endforeach

                        @if ($buys->isEmpty())
                            <tr><th colspan="6">{{ __('Não existem compras') }}</th></tr>
                        @endif
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

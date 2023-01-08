@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="card-header">{{ __('Area pessoal') }}</div>
                    <div class="card-body">
                        <a href="{{ route('user') }}">
                            <img src="{{ asset('storage/images/perfil.jpg') }}" width="50" height="50">
                            {{ __('Perfil') }}
                        </a>
                        @if (Auth::user()->is_admin)
                            <a href="{{ route('users') }}">
                                <img src="{{ asset('storage/images/utilizadores.png') }}" width="50" height="50">
                                {{ __('Utilizadores') }}
                            </a>
                        @endif                        
                    </div>                    
                    <div class="card-header">{{ __('Anuncios') }}</div>
                    <div class="card-body">
                        <a href="{{ route('ad.edit') }}">
                            <img src="{{ asset('storage/images/criarNovo.png') }}" width="50" height="50">
                            {{ __('Criar novo anuncio') }}
                        </a>
                        <a href="{{ route('report.ads') }}">
                            <img src="{{ asset('storage/images/meusAnuncios.png') }}" width="50" height="50">
                            {{ __('Os meus anuncios') }}
                        </a>
                        <a href="{{ route('report.sales') }}">
                            <img src="{{ asset('storage/images/minhasVendas.png') }}" width="50" height="50">
                            {{ __('As minhas vendas') }}
                        </a>
                        <a href="{{ route('report.buys') }}">
                            <img src="{{ asset('storage/images/minhasCompras.jpeg') }}" width="50" height="50">
                            {{ __('As minhas compras') }}
                        </a>
                    </div>
                    @if (Auth::user()->is_admin)                                        
                        <div class="card-header">{{ __('Estatisticas') }}</div>
                        <div class="card-body">
                            Top compradores
                            Top vendedores
                            Número de vendas do último mês                        
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
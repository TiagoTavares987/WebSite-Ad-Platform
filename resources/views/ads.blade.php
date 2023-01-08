@extends('layouts.app')

@section('search')
@include('partials.search')
@endsection

@section('content')
@include('partials.ads')
@endsection

@section('welcome')
@guest
@if (Request::is('/'))

@include('partials.styleFadeIn')
<div id="wrapper" class="fadeInDown" onclick="document.getElementById('wrapper').remove()">
    <div id="wrapperContent">
        <br/><br/><br/><br/><br/><br/><br/><br/>
        Bem vindo
        <br/><br/><br/><br/><br/>
        <button type="button" class="btn btn-primary" onclick="document.getElementById('wrapper').remove()">Fechar</button>
        <br/><br/><br/>
    </div>
</div>

@endif
@endguest
@endsection
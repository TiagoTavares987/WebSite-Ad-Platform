@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if($isNew)
                        {{ __('Criar Anuncio') }}
                    @else
                        {{ __('Editar Anuncio') }}
                    @endif
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
                    @if($isNew)
                        <form method="POST" action="{{ route('ad.create') }}" enctype="multipart/form-data">
                    @else
                        <form method="POST" action="{{ route('ad.update') }}" enctype="multipart/form-data">
                        <input type="hidden" name="adId" value="{{ $ad->id }}">
                    @endif
                    
                        @csrf

                        <div class="row mb-3">
                            <label for="nome" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                            <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ $ad->nome }}" required autocomplete="nome" autofocus>

                                @error('nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="descricao" class="col-md-4 col-form-label text-md-end">{{ __('Descrição') }}</label>

                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ $ad->descricao }}" required autocomplete="descricao" autofocus>

                                @error('descricao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="preco" class="col-md-4 col-form-label text-md-end">{{ __('Preço') }}</label>

                            <div class="col-md-6">
                                <input id="preco" type="text" class="form-control @error('preco') is-invalid @enderror" name="preco" value="{{ $ad->preco }}" required autocomplete="preco" autofocus>

                                @error('preco')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="quantidade" class="col-md-4 col-form-label text-md-end">{{ __('Quantidade') }}</label>

                            <div class="col-md-6">
                                <input id="quantidade" type="text" class="form-control @error('quantidade') is-invalid @enderror" name="quantidade" value="{{ $ad->quantidade }}" required autocomplete="quantidade" autofocus>

                                @error('quantidade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="imageId" class="col-md-4 col-form-label text-md-end">{{ __('Imagem') }}</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    @if($isNew)
                                        <input id="imageId" name="imageId" class="form-control" type="file" accept="image/jpg, image/jpeg, image/png, image/gif, image/svg">
                                        <button id="imageIdClear" class="btn btn-info input-group-text" type="button" onclick="document.getElementById('imageId').value='';">{{ __('limpar') }}</button>
                                    @else
                                        <div class="input-group-text">
                                            <input id="hasImage" name="hasImage" class="form-check-input mt-0" type="checkbox" onclick="document.getElementById('imageId').disabled=!this.checked;document.getElementById('imageIdClear').disabled=!this.checked;">
                                        </div>
                                        <input id="imageId" name="imageId" class="form-control" type="file" accept="image/jpg, image/jpeg, image/png, image/gif, image/svg" disabled>
                                        <button id="imageIdClear" class="btn btn-info input-group-text" type="button" onclick="document.getElementById('imageId').value='';" disabled>{{ __('limpar') }}</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    @if($isNew)
                                        {{ __('Criar') }}
                                    @else
                                        {{ __('Atualizar') }}
                                    @endif
                                </button>

                                @if(!$isNew)
                                    <button type="submit" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('ad-form-delete').submit();">
                                        {{ __('Apagar') }}
                                    </button>
                                    <a type="button" class="btn btn-success" href="{{ route('ad') }}?adId={{ $ad->id }}">
                                @else
                                    <a type="button" class="btn btn-success" href="{{ route('dashboard') }}">
                                @endif
                                    {{ __('Cancelar') }}
                                </a>
                            </div>
                        </div>
                    </form>

                    <form id="ad-form-delete" action="{{ route('ad.delete') }}" method="POST" class="d-none">
                        @csrf
                        <input type="text" name="adId" value="{{ $ad->id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

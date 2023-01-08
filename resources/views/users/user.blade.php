@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Perfil') }}</div>

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
                    <form method="POST" action="{{ route('user') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="primeiroNome" type="text" class="form-control" value="{{ $user->email }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="imageId" class="col-md-4 col-form-label text-md-end">{{ __('Imagem') }}</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <input id="hasImage" name="hasImage" class="form-check-input mt-0" type="checkbox" onclick="document.getElementById('imageId').disabled=!this.checked;document.getElementById('imageIdClear').disabled=!this.checked;">
                                    </div>
                                    <input id="imageId" name="imageId" class="form-control" type="file" accept="image/jpg, image/jpeg, image/png, image/gif, image/svg" disabled>
                                    <button id="imageIdClear" class="btn btn-info input-group-text" type="button" onclick="document.getElementById('imageId').value='';" disabled>{{ __('limpar') }}</button>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="primeiroNome" class="col-md-4 col-form-label text-md-end">{{ __('Primeiro Nome') }}</label>

                            <div class="col-md-6">
                                <input id="primeiroNome" type="text" class="form-control @error('primeiroNome') is-invalid @enderror" name="primeiroNome" value="{{ $user->primeiroNome }}" required autocomplete="primeiroNome" autofocus>

                                @error('primeiroNome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="ultimoNome" class="col-md-4 col-form-label text-md-end">{{ __('Último Nome') }}</label>

                            <div class="col-md-6">
                                <input id="ultimoNome" type="text" class="form-control @error('ultimoNome') is-invalid @enderror" name="ultimoNome" value="{{ $user->ultimoNome }}" required autocomplete="ultimoNome" autofocus>

                                @error('ultimoNome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contacto" class="col-md-4 col-form-label text-md-end">{{ __('Contacto') }}</label>

                            <div class="col-md-6">
                                <input id="contacto" type="text" class="form-control @error('contacto') is-invalid @enderror" name="contacto" value="{{ $user->contacto }}" required autocomplete="contacto" autofocus>

                                @error('contacto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nif" class="col-md-4 col-form-label text-md-end">{{ __('Nif') }}</label>

                            <div class="col-md-6">
                                <input id="nif" type="text" class="form-control @error('nif') is-invalid @enderror" name="nif" value="{{ $user->nif }}" required autocomplete="nif" autofocus>

                                @error('nif')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>
                        

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Atualizar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

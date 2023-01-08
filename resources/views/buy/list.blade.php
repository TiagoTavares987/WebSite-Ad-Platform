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
                            <th scope="col">Id</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Primeiro Nome</th>
                            <th scope="col">Último Nome</th>
                            <th scope="col">Bloqueado</th>
                            <th scope="col">Admin</th>
                            <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($compras as $compra)
                            <tr>
                                    <td><img src="{{ Photo::GetUser($user->imageId, $user->is_admin) }}" width="30" heght="30"/></td>
                                    <td>{{ $compra->anuncioId }}</td>
                                    <td>{{ $compra->preco }}</td>
                                    <td>{{ $compra->quantidade }}</td>
                                </form>
                            </tr>
                        @endforeach
                        @if ($compras->isEmpty())                        
                            <tr>
                                <th colspan="5">{{ __('Não existem compras') }}</th>
                            </tr>
                        @endif
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

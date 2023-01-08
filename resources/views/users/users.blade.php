@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Utilizadores') }} 
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
                        @foreach($users as $user)
                            <tr>
                                <form action="{{ route('users') }}" method="POST">
                                @csrf
                                    <th scope="row">
                                        {{ $user->id }}
                                        <input name="id" type="hidden" value="{{ $user->id }}"/>
                                    </th>
                                    <td><img src="{{ Photo::GetUser($user->imageId, $user->is_admin) }}" width="30" heght="30"/></td>
                                    <td>{{ $user->primeiroNome }}</td>
                                    <td>{{ $user->ultimoNome }}</td>
                                    <td>
                                        <div class="form-check">
                                            @if($user->bloqueado)
                                                <input id="bloqueado" name="bloqueado" class="form-check-input" type="checkbox" checked/>
                                            @else
                                                <input id="bloqueado" name="bloqueado" class="form-check-input" type="checkbox"/>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            @if($user->is_admin)
                                                <input id="is_admin" name="is_admin" class="form-check-input" type="checkbox" checked/>
                                            @else
                                                <input id="is_admin" name="is_admin" class="form-check-input" type="checkbox"/>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-info">Atualizar</button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

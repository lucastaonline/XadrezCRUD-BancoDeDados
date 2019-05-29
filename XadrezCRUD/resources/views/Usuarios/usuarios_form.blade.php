@extends('layouts.app')

@section('content')
<div class="container">
    <form>
        <div class="form-group">
            <label for="nome"> Nome </label>
            <input value="{{ $user->name }}" type="text" class="form-control" id="nome" aria-describedby="nameHelp" placeholder="Digite o nome do usuário">
            <small id="nameHelp" class="form-text text-muted"> Nome atualmente cadastrado </small>
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input value="{{ $user->email }}" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Digite o e-mail do usuário">
            <small id="emailHelp" class="form-text text-muted"> E-mail atualmente cadastrado </small>
        </div>
        @if($user->tem_permissao)
            <div class="form-group">
                <label for="permissao">Tem permissão?</label>
                <input checked type="checkbox" class="form-control" id="permissao" aria-describedby="permissaoHelp">
                <small id="permissaoHelp" class="form-text text-muted"> O usuário atualmente tem permissão </small>
            </div>
        @else
            <div class="form-group">
                <label for="permissao">Tem permissão?</label>
                <input type="checkbox" class="form-control" id="permissao" aria-describedby="permissaoHelp">
                <small id="permissaoHelp" class="form-text text-muted"> O usuário atualmente não tem permissão </small>
            </div>
        @endif
    </form>
</div>
@endsection
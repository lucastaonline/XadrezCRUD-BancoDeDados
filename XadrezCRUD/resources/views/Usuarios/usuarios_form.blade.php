@extends('layouts.app')

@section('header')
    @parent
    <script>
        function formSubmit(e) {
            if(!confirm("Você deseja mesmo excluir este usuário? Você nunca mais o verá por aqui :(")) {
                e.preventDefault();
            }
        }
    </script>
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header"> Edição de usuário </div>
        <div class="card-body">
            <form method="POST" action="/usuarios_form/{{ $user->id }}" onsubmit="">
                @csrf
                <div class="form-group">
                    <label for="nome"> Nome </label>
                    <input name="nome" value="{{ $user->name }}" type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" aria-describedby="nameHelp" placeholder="Digite o nome do usuário">
                    @error('nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input name="email" value="{{ $user->email }}" type="email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" placeholder="Digite o e-mail do usuário">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if($user->tem_permissao)
                    <div class="form-group">
                        <label for="permissao">Tem permissão?</label>
                        <input name="tem_permissao" style="width: 2%;" checked type="checkbox" class="form-control" id="permissao" aria-describedby="permissaoHelp">
                        <small id="permissaoHelp" class="form-text text-muted"> Marque a caixa caso deseje que o usuário tenha permissão </small>
                    </div>
                @else
                    <div class="form-group">
                        <label for="permissao">Tem permissão?</label>
                        <input name="tem_permissao" style="width: 2%;" type="checkbox" class="form-control" id="permissao" aria-describedby="permissaoHelp">
                        <small id="permissaoHelp" class="form-text text-muted"> Marque a caixa caso deseje que o usuário tenha permissão </small>
                    </div>
                @endif
                <button class="btn btn-primary" type="submit"> Salvar alterações </button>
                <button  name="delete" class="btn btn-danger" type="submit" value="delete" onclick="formSubmit(event)"> Remover usuário </button>
            </form>
        </div>
</div>
@endsection
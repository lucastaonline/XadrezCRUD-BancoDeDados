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
            <form method="POST" action="/jogadores_form/{{ isset($jogador)? $jogador->id : '' }}" onsubmit="">
                @csrf
                <div class="form-group">
                    <label for="nome"> Nome </label>
                    <input name="nome" value="{{ isset($jogador)? $jogador->nome : '' }}" type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" aria-describedby="nameHelp" placeholder="Digite o nome do jogador">
                    @error('nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="rating"> Rating </label>
                    <input name="rating" value="{{ isset($jogador)? $jogador->rating : '' }}" type="number" class="form-control @error('rating') is-invalid @enderror" id="rating" aria-describedby="ratingHelp" placeholder="Digite a rating do Jogador">
                    @error('rating')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button class="btn btn-primary" type="submit"> Salvar alterações </button>
                @if(isset($jogador))
                    <button  name="delete" class="btn btn-danger" type="submit" value="delete" onclick="formSubmit(event)"> Remover jogador </button>
                @endif
            </form>
        </div>
</div>
@endsection
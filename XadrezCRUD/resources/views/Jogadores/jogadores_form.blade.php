@extends('layouts.app')

@section('header')
    @parent
    <script>
        function formSubmit(e) {
            if(!confirm("Você deseja mesmo excluir este jogador? Você nunca mais o verá por aqui :(")) {
                e.preventDefault();
            }
        }
    </script>
@endsection

@section('content')
<div class="container">
    <div class="card">
        @if(isset($jogador) && $jogadores->contains($jogador))
            <div class="card-header"> Edição de jogador </div>
        @else
            <div class="card-header"> Criação de jogador </div>
        @endif
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
                @if(isset($jogador) && $jogadores->contains($jogador))
                    <button class="btn btn-primary" type="submit"> Salvar alterações </button>
                    <button  name="delete" class="btn btn-danger" type="submit" value="delete" onclick="formSubmit(event)"> Remover jogador </button>
                @else
                    <button class="btn btn-primary" type="submit"> Criar jogador </button>
                @endif
            </form>
        </div>
</div>
@endsection
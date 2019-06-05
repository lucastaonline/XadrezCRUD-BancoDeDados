@extends('layouts.app')

@section('header')
    @parent
    <script>
        function formSubmit(e) {
            if(!confirm("Você deseja mesmo excluir esta avaliação de lance? Você nunca mais irá vê-la por aqui :(")) {
                e.preventDefault();
            }
        }
    </script>
@endsection

@section('content')
<div class="container">
    <div class="card">
        @if(isset($avaliacao_lance) && $avaliacoes_lance->contains($avaliacao_lance))
            <div class="card-header"> Edição de avaliação de lance </div>
        @else
            <div class="card-header"> Criação de avaliação de lance </div>
        @endif
        <div class="card-body">
            <form method="POST" action="/avaliacoes_lance_form/{{ isset($avaliacao_lance)? $avaliacao_lance->id : '' }}" onsubmit="">
                @csrf
                <div class="form-group">
                    <label for="nome"> Nome </label>
                    <input name="nome" value="{{ isset($avaliacao_lance)? $avaliacao_lance->nome : '' }}" type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" aria-describedby="nameHelp" placeholder="Digite o nome da avaliação de lance">
                    @error('nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if(isset($avaliacao_lance) && $avaliacoes_lance->contains($avaliacao_lance))
                    <button class="btn btn-primary" type="submit"> Salvar alterações </button>
                    <button  name="delete" class="btn btn-danger" type="submit" value="delete" onclick="formSubmit(event)"> Remover avaliação de lance </button>
                @else
                    <button class="btn btn-primary" type="submit"> Criar avaliação de lance </button>
                @endif
            </form>
        </div>
</div>
@endsection
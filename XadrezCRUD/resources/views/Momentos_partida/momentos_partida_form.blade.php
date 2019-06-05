@extends('layouts.app')

@section('header')
    @parent
    <script>
        function formSubmit(e) {
            if(!confirm("Você deseja mesmo excluir este momento de partida? Você nunca mais o verá por aqui :(")) {
                e.preventDefault();
            }
        }
    </script>
@endsection

@section('content')
<div class="container">
    <div class="card">
        @if(isset($momento_partida) && $momentos_partida->contains($momento_partida))
            <div class="card-header"> Edição de momento de partida </div>
        @else
            <div class="card-header"> Criação de momento de partida </div>
        @endif
        <div class="card-body">
            <form method="POST" action="/momentos_partida_form/{{ isset($momento_partida)? $momento_partida->id : '' }}" onsubmit="">
                @csrf
                <div class="form-group">
                    <label for="nome"> Nome </label>
                    <input name="nome" value="{{ isset($momento_partida)? $momento_partida->nome : '' }}" type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" aria-describedby="nameHelp" placeholder="Digite o nome do momento de partida">
                    @error('nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if(isset($momento_partida) && $momentos_partida->contains($momento_partida))
                    <button class="btn btn-primary" type="submit"> Salvar alterações </button>
                    <button  name="delete" class="btn btn-danger" type="submit" value="delete" onclick="formSubmit(event)"> Remover momento de partida </button>
                @else
                    <button class="btn btn-primary" type="submit"> Criar momento de partida </button>
                @endif
            </form>
        </div>
</div>
@endsection
@extends('layouts.app')

@section('header')
    @parent
    <script>
        function formSubmit(e) {
            if(!confirm("Você deseja mesmo excluir este tipo de partida? Você nunca mais o verá por aqui :(")) {
                e.preventDefault();
            }
        }
    </script>
@endsection

@section('content')
<div class="container">
    <div class="card">
        @if(isset($tipo_de_partida))
            <div class="card-header"> Edição de tipo de partida </div>
        @else
            <div class="card-header"> Criação de tipo de partida </div>
        @endif
        <div class="card-body">
            <form method="POST" action="/tipos_de_partida_form/{{ isset($tipo_de_partida)? $tipo_de_partida->id : '' }}" onsubmit="">
                @csrf
                <div class="form-group">
                    <label for="nome"> Nome </label>
                    <input name="nome" value="{{ isset($tipo_de_partida)? $tipo_de_partida->nome : '' }}" type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" aria-describedby="nameHelp" placeholder="Digite o nome do tipo de partida">
                    @error('nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if(isset($tipo_de_partida))
                    <button class="btn btn-primary" type="submit"> Salvar alterações </button>
                    <button  name="delete" class="btn btn-danger" type="submit" value="delete" onclick="formSubmit(event)"> Remover tipo de partida </button>
                @else
                    <button class="btn btn-primary" type="submit"> Criar tipo de partida </button>
                @endif
            </form>
        </div>
</div>
@endsection
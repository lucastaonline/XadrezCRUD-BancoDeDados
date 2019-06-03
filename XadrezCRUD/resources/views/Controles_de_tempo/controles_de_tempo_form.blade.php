@extends('layouts.app')

@section('header')
    @parent
    <script>
        function formSubmit(e) {
            if(!confirm("Você deseja mesmo excluir este controle de tempo? Você nunca mais o verá por aqui :(")) {
                e.preventDefault();
            }
        }
    </script>
@endsection

@section('content')
<div class="container">
    <div class="card">
        @if(isset($controle_de_tempo))
            <div class="card-header"> Edição de controle de tempo </div>
        @else
            <div class="card-header"> Criação de controle de tempo </div>
        @endif
        <div class="card-body">
            <form method="POST" action="/controles_de_tempo_form/{{ isset($controle_de_tempo)? $controle_de_tempo->id : '' }}" onsubmit="">
                @csrf
                <div class="form-group">
                    <label for="nome"> Tempo de partida </label>
                    <input name="nome" value="{{ isset($controle_de_tempo)? $controle_de_tempo->nome : '' }}" type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" aria-describedby="nameHelp" placeholder="Digite o nome do controle de tempo">
                    @error('nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nome"> Tempo de partida </label>
                    <input name="nome" value="{{ isset($controle_de_tempo)? $controle_de_tempo->nome : '' }}" type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" aria-describedby="nameHelp" placeholder="Digite o nome do controle de tempo">
                    @error('nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nome"> Tempo de partida </label>
                    <input name="nome" value="{{ isset($controle_de_tempo)? $controle_de_tempo->nome : '' }}" type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" aria-describedby="nameHelp" placeholder="Digite o nome do controle de tempo">
                    @error('nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="tipo_de_partida"> Tipo de partida </label>
                    <input name="tipo_de_partida" value="{{ isset($controle_de_tempo)? $controle_de_tempo->tipo_de_partida : '' }}" type="text" class="form-control @error('tipo_de_partida') is-invalid @enderror" id="tipo_de_partida" aria-describedby="nameHelp" placeholder="Digite o nome do controle de tempo">
                    @error('nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if(isset($controle_de_tempo))
                    <button class="btn btn-primary" type="submit"> Salvar alterações </button>
                    <button  name="delete" class="btn btn-danger" type="submit" value="delete" onclick="formSubmit(event)"> Remover controle de tempo </button>
                @else
                    <button class="btn btn-primary" type="submit"> Criar controle de tempo </button>
                @endif
            </form>
        </div>
</div>
@endsection
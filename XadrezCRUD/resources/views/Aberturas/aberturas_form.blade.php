@extends('layouts.app')

@section('header')
    @parent
    <script>
        function formSubmit(e) {
            if(!confirm("Você deseja mesmo excluir esta abertura? Você nunca mais irá vê-la por aqui :(")) {
                e.preventDefault();
            }
        }
    </script>
@endsection

@section('content')
<div class="container">
    <div class="card">
        @if(isset($abertura) && $aberturas->contains($abertura))
            <div class="card-header"> Edição de abertura </div>
        @else
            <div class="card-header"> Criação de abertura </div>
        @endif
        <div class="card-body">
            <form method="POST" action="/aberturas_form/{{ isset($abertura)? $abertura->id : '' }}" onsubmit="">
                @csrf
                <div class="form-group">
                    <label for="nome"> Nome </label>
                    <input name="nome" value="{{ isset($abertura)? $abertura->nome : '' }}" type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" aria-describedby="nameHelp" placeholder="Digite o nome da abertura">
                    @error('nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if(isset($abertura) && $aberturas->contains($abertura))
                    <button class="btn btn-primary" type="submit"> Salvar alterações </button>
                    <button  name="delete" class="btn btn-danger" type="submit" value="delete" onclick="formSubmit(event)"> Remover abertura </button>
                @else
                    <button class="btn btn-primary" type="submit"> Criar abertura </button>
                @endif
            </form>
        </div>
</div>
@endsection
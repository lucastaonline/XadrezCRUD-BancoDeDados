@extends('layouts.app')

@section('header')
    @parent
    <script>
        function formSubmit(e) {
            if(!confirm("Você deseja mesmo excluir esta variação de rating? Você nunca mais irá vê-la por aqui :(")) {
                e.preventDefault();
            }
        }
    </script>
@endsection

@section('content')
<div class="container">
    <div class="card">
        @if(isset($variacao_rating) && $variacoes_rating->contains($variacao_rating))
            <div class="card-header"> Edição de variação de rating </div>
        @else
            <div class="card-header"> Criação de variação de rating </div>
        @endif
        <div class="card-body">
            <form method="POST" action="/variacoes_rating_form/{{ isset($variacao_rating)? $variacao_rating->id : '' }}" onsubmit="">
                @csrf
                <div class="form-group">
                    <label for="id_partida"> Partida da variação </label>
                    <select class="form-control  @if(isset($errorPartida) || $errors->has('id_partida')) is-invalid @endif" id="id_partida" name="id_partida">
                        <option value=""> -- Selecione uma partida --</option>
                        @foreach($partidas as $partida)
                            <option value="{{$partida->id}}" {{
                                                                isset($variacao_rating)? 
                                                                (($variacao_rating->id_partida == $partida->id)? 'selected' : '') : '' 
                                                            }}> 
                                    {{
                                        $jogadores->firstWhere('id',$partida->id_jogador_brancas)->nome
                                    }} vs 
                                    {{
                                        $jogadores->firstWhere('id',$partida->id_jogador_negras)->nome
                                    }} |
                                    {{
                                        $partida->data_da_partida
                                    }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_partida')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if(isset($errorPartida))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errorPartida }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="id_jogador"> Jogador da variação </label>
                    <select class="form-control  @if(isset($errorJogador) || $errors->has('id_jogador')) is-invalid @endif" id="id_jogador" name="id_jogador">
                        <option value=""> -- Selecione um jogador --</option>
                        @foreach($jogadores as $jogador)
                            <option value="{{$jogador->id}}" {{ isset($variacao_rating)? (($variacao_rating->id_jogador == $jogador->id)? 'selected' : '') : '' }}> {{ $jogador->nome }} </option>
                        @endforeach
                    </select>
                    @error('id_jogador')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if(isset($errorJogador))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errorJogador }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="variacao"> Variação do rating </label>
                    <input name="variacao" value="{{ isset($variacao_rating)? $variacao_rating->variacao : '' }}" type="number" class="form-control @error('variacao') is-invalid @enderror" id="variacao" aria-describedby="nameHelp" placeholder="Digite a variação de rating">
                    @error('variacao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if(isset($variacao_rating) && $variacoes_rating->contains($variacao_rating))
                    <button class="btn btn-primary" type="submit"> Salvar alterações </button>
                    <button  name="delete" class="btn btn-danger" type="submit" value="delete" onclick="formSubmit(event)"> Remover variação de rating </button>
                @else
                    <button class="btn btn-primary" type="submit"> Criar variação de rating </button>
                @endif
            </form>
        </div>
</div>
@endsection
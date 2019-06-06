@extends('layouts.app')

@section('header')
    @parent
    <script>
        function formSubmit(e) {
            if(!confirm("Você deseja mesmo excluir este lance? Você nunca mais o verá por aqui :(")) {
                e.preventDefault();
            }
        }
    </script>
@endsection

@section('content')
<div class="container">
    <div class="card">
        @if(isset($lance) && $lances->contains($lance))
            <div class="card-header"> Edição de lance </div>
        @else
            <div class="card-header"> Criação de lance </div>
        @endif
        <div class="card-body">
            <form method="POST" action="/lances_form/{{ isset($lance)? $lance->id : '' }}" onsubmit="">
                @csrf
                <div class="form-group">
                    <label for="id_jogador"> Jogador do lance </label>
                    <select class="form-control  @error('id_jogador') is-invalid @enderror" id="id_jogador" name="id_jogador">
                        <option> -- Selecione um jogador --</option>
                        @foreach($jogadores as $jogador)
                            <option value="{{$jogador->id}}" {{ isset($lance)? (($lance->id_jogador == $jogador->id)? 'selected' : '') : '' }}> {{ $jogador->nome }} </option>
                        @endforeach
                    </select>
                    @error('id_jogador')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="id_partida"> Partida do lance </label>
                    <select class="form-control  @error('id_partida') is-invalid @enderror" id="id_partida" name="id_partida">
                        <option> -- Selecione uma partida --</option>
                        @foreach($partidas as $partida)
                            <option value="{{$partida->id}}" {{ isset($lance)? (($lance->id_partida == $partida->id)? 'selected' : '') : '' }}> {{ $partida->id }} </option>
                        @endforeach
                    </select>
                    @error('id_partida')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="numero_lance"> Número do lance </label>
                    <input name="numero_lance" value="{{ isset($lance)? $lance->numero_lance : '' }}" type="number" class="form-control @error('numero_lance') is-invalid @enderror" id="numero_lance" aria-describedby="nameHelp" placeholder="Digite o nome do lance">
                    @error('numero_lance')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="id_avaliacao_lance"> Avaliação do lance </label>
                    <select class="form-control  @error('id_avaliacao_lance') is-invalid @enderror" id="id_avaliacao_lance" name="id_avaliacao_lance">
                        <option> -- Selecione uma avaliação --</option>
                        @foreach($avaliacoes_lance as $avaliacao_lance)
                            <option value="{{$avaliacao_lance->id}}" {{ isset($lance)? (($lance->id_avaliacao_lance == $avaliacao_lance->id)? 'selected' : '') : '' }}> {{ $avaliacao_lance->nome }} </option>
                        @endforeach
                    </select>
                    @error('id_avaliacao_lance')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="id_momento_partida"> Momento de partida do lance </label>
                    <select class="form-control  @error('id_momento_partida') is-invalid @enderror" id="id_momento_partida" name="id_momento_partida">
                        <option> -- Selecione um momento de partida--</option>
                        @foreach($momentos_partida as $momento_partida)
                            <option value="{{$momento_partida->id}}" {{ isset($lance)? (($lance->id_momento_partida == $momento_partida->id)? 'selected' : '') : '' }}> {{ $momento_partida->nome }} </option>
                        @endforeach
                    </select>
                    @error('id_momento_partida')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if(isset($lance) && $lances->contains($lance))
                    <button class="btn btn-primary" type="submit"> Salvar alterações </button>
                    <button  name="delete" class="btn btn-danger" type="submit" value="delete" onclick="formSubmit(event)"> Remover lance </button>
                @else
                    <button class="btn btn-primary" type="submit"> Criar lance </button>
                @endif
            </form>
        </div>
</div>
@endsection
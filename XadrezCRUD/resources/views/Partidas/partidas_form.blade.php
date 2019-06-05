@extends('layouts.app')

@section('header')
    @parent
    <script>
        function formSubmit(e) {
            if(!confirm("Você deseja mesmo excluir esta partida? Você nunca mais o verá por aqui :(")) {
                e.preventDefault();
            }
        }
        
    </script>
@endsection

@section('content')
<div class="container">
    <div class="card">
        @if(isset($partida))
            <div class="card-header"> Edição de partida </div>
        @else
            <div class="card-header"> Criação de partida </div>
        @endif
        <div class="card-body">
            <form method="POST" action="/partidas_form/{{ isset($partida)? $partida->id : '' }}" onsubmit="">
                @csrf
                <div class="form-group">
                    <label for="id_jogador_brancas"> Jogador das peças brancas </label>
                    <select class="form-control  @error('id_jogador_brancas') is-invalid @enderror" id="id_jogador_brancas" name="id_jogador_brancas">
                        <option> -- Selecione um jogador --</option>
                        @foreach($jogadores as $jogador)
                            <option value="{{$jogador->id}}" {{ isset($partida)? (($partida->id_jogador_brancas == $jogador->id)? 'selected' : '') : '' }}> {{ $jogador->nome }} </option>
                        @endforeach
                    </select>
                    @error('id_jogador_brancas')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="id_jogador_negras"> Jogador das peças negras </label>
                    <select class="form-control  @error('id_jogador_negras') is-invalid @enderror" id="id_jogador_negras" name="id_jogador_negras">
                        <option> -- Selecione um jogador --</option>
                        @foreach($jogadores as $jogador)
                            <option value="{{$jogador->id}}" {{ isset($partida)? (($partida->id_jogador_negras == $jogador->id)? 'selected' : '') : '' }}> {{ $jogador->nome }} </option>
                        @endforeach
                    </select>
                    @error('id_jogador_negras')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="data_da_partida"> Data da partida </label>
                    <input name="data_da_partida" class="form-control @error('data_da_partida') is-invalid @enderror" value="{{ isset($partida)? $partida->data_da_partida : '' }}" type="datetime-local"/>
                    @error('data_da_partida')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="id_controle_de_tempo">  Controle de tempo da partida </label>
                    <select class="form-control  @error('id_controle_de_tempo') is-invalid @enderror" id="id_controle_de_tempo" name="id_controle_de_tempo">
                        <option> -- Selecione um controle de tempo --</option>
                        @foreach($controles_de_tempo as $controle_de_tempo)
                            <option value="{{$controle_de_tempo->id}}" 
                            {{ isset($partida)? (($partida->id_controle_de_tempo == $controle_de_tempo->id)?
                             'selected' : '') : '' }}> 
                                {{ $controle_de_tempo->tempo_partida }} min | 
                                {{ $controle_de_tempo->tem_incremento? $controle_de_tempo->incremento . " seg de incremento" : '' }} |
                                {{ App\Tipo_de_partida::find($controle_de_tempo->id_tipo_de_partida )->nome $tipos_de_partida }}
                             </option>
                        @endforeach
                    </select>
                    @error('id_controle_de_tempo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if(isset($partida))
                    <button class="btn btn-primary" type="submit"> Salvar alterações </button>
                    <button  name="delete" class="btn btn-danger" type="submit" value="delete" onclick="formSubmit(event)"> Remover partida </button>
                @else
                    <button class="btn btn-primary" type="submit"> Criar partida </button>
                @endif
            </form>
        </div>
</div>
@endsection
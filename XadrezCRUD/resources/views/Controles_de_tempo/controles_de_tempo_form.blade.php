@extends('layouts.app')

@section('header')
    @parent
    <script>
        function formSubmit(e) {
            if(!confirm("Você deseja mesmo excluir este controle de tempo? Você nunca mais o verá por aqui :(")) {
                e.preventDefault();
            }
        }

        $('document').ready(() => {
            $('#tem_incremento_label').on('click', () => {
                $('#incremento_div').removeClass('d-none');
            });
            $('#nao_tem_incremento_label').on('click', () => {
                $('#incremento_div').addClass('d-none');
                $('#incremento').val("");
            });
        })
        
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
                    <label for="tempo_partida"> Tempo de partida </label>
                    <input name="tempo_partida" value="{{ isset($controle_de_tempo)? $controle_de_tempo->tempo_partida : '' }}" type="number" class="form-control @error('tempo_partida') is-invalid @enderror" id="tempo_partida" aria-describedby="tempo_partidaHelp" placeholder="Digite o tempo de partida">
                    @error('tempo_partida')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="tem_incremento_div"> Tem incremento? </label><br/>
                    <div class="btn-group btn-group-toggle form-control @error('tem_incremento') is-invalid @enderror" style="width: unset;padding: unset;height: unset;" data-toggle="buttons">
                        <label id="tem_incremento_label" class="btn btn-primary {{ isset($controle_de_tempo)? ($controle_de_tempo->tem_incremento == true? 'active' : '') : '' }}">
                            <input type="radio" name="tem_incremento" id="tem_incremento" autocomplete="off" value="true" {{ isset($controle_de_tempo)? ($controle_de_tempo->tem_incremento == true? 'checked' : '') : '' }}> Sim
                        </label>
                        <label id="nao_tem_incremento_label" class="btn btn-primary {{ isset($controle_de_tempo)? ($controle_de_tempo->tem_incremento == false? 'active' : '') : '' }}">
                            <input class="@error('tem_incremento') is-invalid @enderror" type="radio" name="tem_incremento" id="nao_tem_incremento" autocomplete="off" value="false" {{ isset($controle_de_tempo)? ($controle_de_tempo->tem_incremento == false? 'checked' : '') : '' }}> Não
                        </label>
                    </div>
                    @error('tem_incremento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div id="incremento_div" class="form-group {{ isset($controle_de_tempo)? ($controle_de_tempo->tem_incremento == false? 'd-none' : '') : 'd-none' }}">
                    <label for="incremento"> Incremento </label>
                    <input name="incremento" value="{{ isset($controle_de_tempo)? $controle_de_tempo->incremento : '' }}" type="number" class="form-control @error('incremento') is-invalid @enderror" id="incremento" aria-describedby="incrementoHelp" placeholder="Digite a quantidade do incremento">
                    @error('incremento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="id_tipo_de_partida"> Tipo de partida </label>
                    <select class="form-control  @error('id_tipo_de_partida') is-invalid @enderror" id="id_tipo_de_partida" name="id_tipo_de_partida">
                        <option> -- Selecione um tipo de partida --</option>
                        @foreach($tipos_de_partida as $tipo_de_partida)
                            <option value="{{$tipo_de_partida->id}}" {{ isset($controle_de_tempo)? (($controle_de_tempo->id_tipo_de_partida == $tipo_de_partida->id)? 'selected' : '') : '' }}> {{ $tipo_de_partida->nome }} </option>
                        @endforeach
                    </select>
                    @error('id_tipo_de_partida')
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
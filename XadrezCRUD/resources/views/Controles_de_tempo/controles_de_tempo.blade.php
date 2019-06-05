@extends('layouts.app')

@section('header')
    @parent

@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (session('badstatus'))
        <div class="alert alert-danger">
            {{ session('badstatus') }}
        </div>
    @endif
    <div class="container">
        <a href="/controles_de_tempo_form" class="btn btn-primary" style="color: white; margin-bottom: 20px;"> Criar controle de tempo </a>
        @if(count($controles_de_tempo) == 0)
            <div class="card">
                <div class="card-header"> Ninguém fez bagunça aqui! </div>
                <div class="card-body">
                    Não temos nenhum registro de controle de tempo. (ainda)
                </div>
            </div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Tempo de partida
                        </th>
                        <th>
                            Tem incremento?
                        </th>
                        <th>
                            Incremento
                        </th>
                        <th>
                            Tipo de partida
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($controles_de_tempo as $controle_de_tempo)
                        <tr>
                            <td>
                                {{ $controle_de_tempo->id }}
                            </td>
                            <td>
                                {{ $controle_de_tempo->tempo_partida }} minutos
                            </td>
                            <td>
                            @if($controle_de_tempo->tem_incremento)
                                <span class="oi" data-glyph="check" title="check" aria-hidden="true" style="color: green;"></span>
                            @else
                                <span class="oi" data-glyph="x" title="x" aria-hidden="true" style="color: red;"></span>
                            @endif
                            </td>
                            <td>
                                {{ isset($controle_de_tempo->incremento)? $controle_de_tempo->incremento . ' segundos' : '' }}
                            </td>
                            <td>
                                @foreach($tipos_de_partida as $tipo_de_partida)
                                    @if($tipo_de_partida->id == $controle_de_tempo->id_tipo_de_partida)
                                        {{ $tipo_de_partida->nome }}
                                    @endif
                                @endforeach
                            </td>
                            <td style="text-align: right;">
                                <a class="btn btn-primary" href="controles_de_tempo_form/{{ $controle_de_tempo->id }}" style="color: white"> Editar </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
@endsection
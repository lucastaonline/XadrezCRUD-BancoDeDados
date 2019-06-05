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
        <a href="/partidas_form" class="btn btn-primary" style="color: white; margin-bottom: 20px;"> Criar partidas </a>
        @if(count($partidas) == 0)
            <div class="card">
                <div class="card-header"> Ninguém fez bagunça aqui! </div>
                <div class="card-body">
                    Não temos nenhum registro de partidas. (ainda)
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
                            Jogador brancas
                        </th>
                        <th>
                            Jogador negras
                        </th>
                        <th>
                            Data
                        </th>
                        <th>
                            Vencedor
                        </th>
                        <th>
                            Controle de tempo
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($partidas as $partida)
                        <tr>
                            <td>
                                {{ $partida->id }}
                            </td>
                            <td>
                                {{ $jogadores->firstWhere('id',$partida->id_jogador_brancas)->nome }}
                            </td>
                            <td>
                                {{ $jogadores->firstWhere('id',$partida->id_jogador_negras)->nome }}
                            </td>
                            <td>
                                {{ $partida->data_da_partida->format('d/m/Y H:i:s') }}
                            </td>
                            <td>
                                {{ isset($partida->id_jogador_vencedor)? $partida->id_jogador_vencedor : 'Jogador ainda não definido' }}
                            </td>
                            <td>
                                {{ 
                                    $controles_de_tempo
                                    ->firstWhere('id',$partida->id_controle_de_tempo)
                                    ->tempo_partida
                                }} min | 
                                {{ 
                                    $controles_de_tempo
                                    ->firstWhere('id',$partida->id_controle_de_tempo)
                                    ->tem_incremento? $controles_de_tempo
                                                        ->firstWhere('id',$partida->id_controle_de_tempo)
                                                        ->incremento . " seg de incremento" : 'Não tem incremento' 
                                }} |
                                {{
                                    $tipos_de_partida
                                    ->firstWhere('id',$controles_de_tempo->firstWhere('id',$partida->id_controle_de_tempo)
                                    ->id_tipo_de_partida)
                                    ->nome 
                                }}
                            </td>
                            <td style="text-align: right;">
                                <a class="btn btn-primary" href="partidas_form/{{ $partida->id }}" style="color: white"> Editar </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
@endsection
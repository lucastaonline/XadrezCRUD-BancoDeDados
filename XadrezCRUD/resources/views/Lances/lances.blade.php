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
        <a href="/lances_form" class="btn btn-primary" style="color: white; margin-bottom: 20px;"> Criar lance </a>
        @if(count($lances) == 0)
            <div class="card">
                <div class="card-header"> Ninguém fez bagunça aqui! </div>
                <div class="card-body">
                    Não temos nenhum registro de lances no banco. (ainda)
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
                            Partida
                        </th>
                        <th>
                            Jogador
                        </th>
                        <th>
                            Nome
                        </th>
                        <th>
                            Número
                        </th>
                        <th>
                            Avaliação do lance
                        </th>
                        <th>
                            Nível de avaliação do lance
                        </th>
                        <th>
                            Momento da partida
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lances as $lance)
                        <tr>
                            <td>
                                {{ $lance->id }}
                            </td>
                            <td>
                                {{
                                    $jogadores->firstWhere('id',$partidas->firstWhere('id',$lance->id_partida)->id_jogador_brancas)->nome
                                }} vs 
                                {{
                                    $jogadores->firstWhere('id',$partidas->firstWhere('id',$lance->id_partida)->id_jogador_negras)->nome
                                }} |
                                {{
                                    $partidas->firstWhere('id',$lance->id_partida)->data_da_partida->format("d/m/Y H:i:s")
                                }}
                            </td>
                            <td>
                                {{ $jogadores->firstWhere('id',$lance->id_jogador)->nome }}
                            </td>
                            <td>
                                {{ $lance->nome }}
                            </td>
                            <td>
                                {{ $lance->numero_lance }}
                            </td>
                            <td>
                                {{ $avaliacoes_lance->firstWhere('id',$lance->id_avaliacao_lance)->nome }}
                            </td>
                            <td>
                                {{ $lance->nivel_avaliacao }}
                            </td>
                            <td>
                                {{ $momentos_partida->firstWhere('id',$lance->id_momento_partida)->nome }}
                            </td>
                            <td style="text-align: right;">
                                <a class="btn btn-primary" href="lances_form/{{ $lance->id }}" style="color: white"> Editar </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
@endsection
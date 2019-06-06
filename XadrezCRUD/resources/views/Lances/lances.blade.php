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
                            Jogador
                        </th>
                        <th>
                            Partida
                        </th>
                        <th>
                            Número
                        </th>
                        <th>
                            Avaliação do lance
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
                                {{ $jogadores->firstWhere('id',$lance->id_jogador) }}
                            </td>
                            <td>
                                {{ $partidas->firstWhere('id',$lance->id_partida) }}
                            </td>
                            <td>
                                {{ $lance->numero_lance }}
                            </td>
                            <td>
                                {{ $avaliacoes_lance->firstWhere('id',$lance->id_avaliacao_lance) }}
                            </td>
                            <td>
                                {{ $momentos_partida->firstWhere('id',$lance->id_momento_partida) }}
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
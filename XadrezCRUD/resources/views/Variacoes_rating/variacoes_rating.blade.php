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
        <a href="/variacoes_rating_form" class="btn btn-primary" style="color: white; margin-bottom: 20px;"> Criar variação de rating </a>
        @if(count($variacoes_rating) == 0)
            <div class="card">
                <div class="card-header"> Ninguém fez bagunça aqui! </div>
                <div class="card-body">
                    Não temos nenhum registro de variações de rating no banco. (ainda)
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
                            Variação
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($variacoes_rating as $variacao_rating)
                        <tr>
                            <td>
                                {{ $variacao_rating->id }}
                            </td>
                            <td>
                                {{
                                    $jogadores->firstWhere('id',$partidas->firstWhere('id',$variacao_rating->id_partida)->id_jogador_brancas)->nome
                                }} vs 
                                {{
                                    $jogadores->firstWhere('id',$partidas->firstWhere('id',$variacao_rating->id_partida)->id_jogador_negras)->nome
                                }} |
                                {{
                                    $partidas->firstWhere('id',$variacao_rating->id_partida)->data_da_partida
                                }}
                            </td>
                            <td>
                                {{ $jogadores->firstWhere('id',$variacao_rating->id_jogador)->nome }}
                            </td>
                            <td>
                                {{ $variacao_rating->variacao }}
                            </td>
                            <td style="text-align: right;">
                                <a class="btn btn-primary" href="variacoes_rating_form/{{ $variacao_rating->id }}" style="color: white"> Editar </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
@endsection
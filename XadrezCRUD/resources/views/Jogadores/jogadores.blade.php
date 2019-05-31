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
            {{ session('status') }}
        </div>
    @endif
    <div class="container">
        <a href="/jogadores_form" class="btn btn-primary" style="color: white; margin-bottom: 20px;"> Criar jogador </a>
        @if(count($jogadores) == 0)
            <div class="card">
                <div class="card-header"> Ninguém fez bagunça aqui! </div>
                <div class="card-body">
                    Não temos nenhum registro de jogadores no banco. (ainda)
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
                            Nome =D
                        </th>
                        <th>
                            Rating
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jogadores as $jogador)
                        <tr>
                            <td>
                                {{ $jogador->id }}
                            </td>
                            <td>
                                {{ $jogador->nome }}
                            </td>
                            <td>
                                {{ $jogador->rating }}
                            </td>
                            <td style="text-align: right;">
                                <a class="btn btn-primary" href="jogadores_form/{{ $jogador->id }}" style="color: white"> Editar </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
@endsection
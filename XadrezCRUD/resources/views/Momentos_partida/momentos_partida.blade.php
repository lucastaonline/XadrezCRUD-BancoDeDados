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
        <a href="/momentos_partida_form" class="btn btn-primary" style="color: white; margin-bottom: 20px;"> Criar momento de partida</a>
        @if(count($momentos_partida) == 0)
            <div class="card">
                <div class="card-header"> Ninguém fez bagunça aqui! </div>
                <div class="card-body">
                    Não temos nenhum registro de momentos de partida no banco. (ainda)
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
                            Nome
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($momentos_partida as $momento_partida)
                        <tr>
                            <td>
                                {{ $momento_partida->id }}
                            </td>
                            <td>
                                {{ $momento_partida->nome }}
                            </td>
                            <td style="text-align: right;">
                                <a class="btn btn-primary" href="momentos_partida_form/{{ $momento_partida->id }}" style="color: white"> Editar </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
@endsection
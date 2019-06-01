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
        <a href="/tipos_de_partida_form" class="btn btn-primary" style="color: white; margin-bottom: 20px;"> Criar tipo de partida</a>
        @if(count($tipos_de_partida) == 0)
            <div class="card">
                <div class="card-header"> Ninguém fez bagunça aqui! </div>
                <div class="card-body">
                    Não temos nenhum registro de tipos de partida no banco. (ainda)
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
                    @foreach ($tipos_de_partida as $tipo_de_partida)
                        <tr>
                            <td>
                                {{ $tipo_de_partida->id }}
                            </td>
                            <td>
                                {{ $tipo_de_partida->nome }}
                            </td>
                            <td style="text-align: right;">
                                <a class="btn btn-primary" href="tipos_de_partida_form/{{ $tipo_de_partida->id }}" style="color: white"> Editar </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
@endsection
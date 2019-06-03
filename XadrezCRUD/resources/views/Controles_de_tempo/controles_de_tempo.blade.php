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
                            Nome
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
                                {{ $controle_de_tempo->nome }}
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
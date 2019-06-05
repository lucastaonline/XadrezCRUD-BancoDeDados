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
        <a href="/aberturas_form" class="btn btn-primary" style="color: white; margin-bottom: 20px;"> Criar abertura</a>
        @if(count($aberturas) == 0)
            <div class="card">
                <div class="card-header"> Ninguém fez bagunça aqui! </div>
                <div class="card-body">
                    Não temos nenhum registro de aberturas no banco. (ainda)
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
                    @foreach ($aberturas as $abertura)
                        <tr>
                            <td>
                                {{ $abertura->id }}
                            </td>
                            <td>
                                {{ $abertura->nome }}
                            </td>
                            <td style="text-align: right;">
                                <a class="btn btn-primary" href="aberturas_form/{{ $abertura->id }}" style="color: white"> Editar </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
@endsection
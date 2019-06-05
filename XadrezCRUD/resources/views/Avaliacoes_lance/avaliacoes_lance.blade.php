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
        <a href="/avaliacoes_lance_form" class="btn btn-primary" style="color: white; margin-bottom: 20px;"> Criar avaliação de lance</a>
        @if(count($avaliacoes_lance) == 0)
            <div class="card">
                <div class="card-header"> Ninguém fez bagunça aqui! </div>
                <div class="card-body">
                    Não temos nenhum registro de avaliações de lance no banco. (ainda)
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
                    @foreach ($avaliacoes_lance as $avaliacao_lance)
                        <tr>
                            <td>
                                {{ $avaliacao_lance->id }}
                            </td>
                            <td>
                                {{ $avaliacao_lance->nome }}
                            </td>
                            <td style="text-align: right;">
                                <a class="btn btn-primary" href="avaliacoes_lance_form/{{ $avaliacao_lance->id }}" style="color: white"> Editar </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
@endsection
@extends('layouts.app')

@section('header')
    @parent

@endsection

@section('content')
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        E-mail
                    </th>
                    <th>
                        Data de criação
                    </th>
                    <th>
                        Tem permissão?
                    </th>
                    <th>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            {{ $user->id }}
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                            {{ $user->created_at }}
                        </td>
                        <td>
                            @if($user->tem_permissao)
                                <span class="oi" data-glyph="check" title="check" aria-hidden="true" style="color: green;"></span>
                            @else
                                <span class="oi" data-glyph="x" title="x" aria-hidden="true" style="color: red;"></span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <a class="btn btn-primary" style="color: white"> Editar </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
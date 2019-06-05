<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Tipo_de_partida;
use Illuminate\Support\Facades\Validator;

class Tipos_de_partida extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostra a tabela de usuarios
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->tem_permissao) {
            $data = [
                'tipos_de_partida' => Tipo_de_partida::all()
            ];
            return view('Tipos_de_partida.tipos_de_partida', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function pegarForm(Tipo_de_partida $tipo_de_partida = null) {
        if(Auth::user()->tem_permissao) {

            $data = [
                'tipo_de_partida' => $tipo_de_partida,
                'tipos_de_partida' => Tipo_de_partida::all()
            ];
            return view('Tipos_de_partida.tipos_de_partida_form', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function enviarForm(Request $request,Tipo_de_partida $tipo_de_partida = null) {
        if(Auth::user()->tem_permissao) {

            $novoTipo_de_partida = !isset($tipo_de_partida);
            $deletarTipo_de_partida = isset($request->delete);

            if($deletarTipo_de_partida) {
                if(!$novoTipo_de_partida) {
                    $tipo_de_partida->delete();
                    return redirect()->action('Tipos_de_partida@index')->with('status', 'O tipo de partida foi removido!');
                }
                else {
                    return redirect()->action('Tipos_de_partida@index')->with('badstatus', 'Não é possível remover um tipo de partida que não existe. Ta mexendo em código fonte né?');
                }
            }

            $validator = Validator::make($request->all(), [
                'nome' => ['required','max:50']
            ],
            [
                'required' => 'O campo ":attribute" é obrigatório',
                'max' => 'O campo ":attribute" deve ter no máximo :max caracteres.'
            ]);

            if($novoTipo_de_partida) {
                $tipo_de_partida = new Tipo_de_partida();
            }

            $tipo_de_partida->nome = $request->nome;
            
            if($validator->fails()) {
                $data = [
                    'tipo_de_partida' => $tipo_de_partida,
                    'errors' => $validator->errors(),
                    'tipos_de_partida' => Tipo_de_partida::all()
                ];
                return view('Tipos_de_partida.tipos_de_partida_form', $data);
            }

            $tipo_de_partida->save();

            return redirect()->action('Tipos_de_partida@index')->with('status', $novoTipo_de_partida? 'O tipo de partida foi criado com sucesso!' : 'As alterações foram salvas!');
        }
        else {
            return view('sem_permissao');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Controle_de_tempo;
use App\Tipo_de_partida;
use Illuminate\Support\Facades\Validator;

class Controles_de_tempo extends Controller
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
                'controles_de_tempo' => Controle_de_tempo::all(),
                'tipos_de_partida' => Tipo_de_partida::all()
            ];
            return view('Controles_de_tempo.controles_de_tempo', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function pegarForm(Controle_de_tempo $controle_de_tempo = null) {
        if(Auth::user()->tem_permissao) {

            $data = [
                'controle_de_tempo' => $controle_de_tempo,
                'tipos_de_partida' => Tipo_de_partida::all(),
                'controles_de_tempo' => Controle_de_tempo::all()
            ];
            return view('Controles_de_tempo.controles_de_tempo_form', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function enviarForm(Request $request,Controle_de_tempo $controle_de_tempo = null) {
        if(Auth::user()->tem_permissao) {

            $request->tem_incremento = ($request->tem_incremento == "true"? true : false);
            $novoControle_de_tempo = !isset($controle_de_tempo);
            $deletarControle_de_tempo = isset($request->delete);

            if($deletarControle_de_tempo) {
                if(!$novoControle_de_tempo) {
                    $controle_de_tempo->delete();       
                    return redirect()->action('Controles_de_tempo@index')->with('status', 'O controle de tempo foi removido!');
                }
                else {
                    return redirect()->action('Controles_de_tempo@index')->with('badstatus', 'Não é possível remover um controle de tempo que não existe. Ta mexendo em código fonte né?');
                }
            }

            $validator = Validator::make($request->all(), [
                'tempo_partida' => ['required','integer','max:2147483647'],
                'tem_incremento' => ['required',],
                'incremento' => [($request->tem_incremento? 'integer' : ''),($request->tem_incremento? 'required' : ''),'max:2147483647'],
                'id_tipo_de_partida' => ['required','exists:Tipo_de_partida,id'],
            ],
            [
                'required' => 'O campo ":attribute" é obrigatório',
                'max' => 'O campo ":attribute" deve ser no máximo :max.',
                'boolean' => 'O valor passado deve ser um booleano. Está bulindo o código espertinho? Passa nada.',
                'number' => 'O campo ":attribute" deve ser um número',
                'id_tipo_de_partida.exists' => 'O campo "Tipo de partida" deve estar vinculado a um tipo de partida que exista. Pare de mecher no código!',
                'integer' => 'O campo deve ser do tipo integer. Para tal, deve ser um número inteiro menor do que 2147483647'
            ]);

            if($novoControle_de_tempo) {
                $controle_de_tempo = new Controle_de_tempo();
            }

            $controle_de_tempo->tempo_partida = $request->tempo_partida;
            $controle_de_tempo->tem_incremento = $request->tem_incremento;
            $controle_de_tempo->incremento = $request->incremento;
            $controle_de_tempo->id_tipo_de_partida = $request->id_tipo_de_partida;
            
            if($validator->fails()) {
                $data = [
                    'controle_de_tempo' => $controle_de_tempo,
                    'tipos_de_partida' => Tipo_de_partida::all(),
                    'errors' => $validator->errors(),
                    'controles_de_tempo' => Controle_de_tempo::all()
                ];
                return view('Controles_de_tempo.controles_de_tempo_form', $data);
            }
            $controle_de_tempo->save();

            return redirect()->action('Controles_de_tempo@index')->with('status', $novoControle_de_tempo? 'O controle de tempo foi criado com sucesso!' : 'As alterações foram salvas!');
        }
        else {
            return view('sem_permissao');
        }
    }
}

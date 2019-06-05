<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Controle_de_tempo;
use App\Partida;
use App\Jogador;
use Illuminate\Support\Facades\Validator;

class Partidas extends Controller
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
                'partidas' => Partida::all(),
                'controles_de_tempo' => Controle_de_tempo::all()
            ];
            return view('Partidas.partidas', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function pegarForm(Controle_de_tempo $partida = null) {
        if(Auth::user()->tem_permissao) {

            $data = [
                'partida' => $partida,
                'controles_de_tempo' => Controle_de_tempo::all(),
                'jogadores' => Jogador::all()
            ];
            return view('Partidas.partidas_form', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function enviarForm(Request $request,Controle_de_tempo $partida = null) {
        if(Auth::user()->tem_permissao) {
            dd($request->all());
            $request->tem_incremento = ($request->tem_incremento == "true"? true : false);
            $novaPartida = !isset($partida);
            $deletarPartida = isset($request->delete);

            if($deletarPartida) {
                if(!$novaPartida) {
                    $partida->delete();       
                    return redirect()->action('Partidas@index')->with('status', 'A partida foi removida!');
                }
                else {
                    return redirect()->action('Partidas@index')->with('badstatus', 'Não é possível remover uma partida que não existe. Ta mexendo em código fonte né?');
                }
            }

            $validator = Validator::make($request->all(), [
                'tempo_partida' => ['required','integer','max:999999999'],
                'tem_incremento' => ['required',],
                'incremento' => [($request->tem_incremento? 'integer' : ''),($request->tem_incremento? 'required' : ''),'max:999999999'],
                'id_tipo_de_partida' => ['required','exists:Tipo_de_partida,id'],
            ],
            [
                'required' => 'O campo ":attribute" é obrigatório',
                'max' => 'O campo ":attribute" deve ser no máximo :max.',
                'boolean' => 'O valor passado deve ser um booleano. Está bulindo o código espertinho? Passa nada.',
                'number' => 'O campo ":attribute" deve ser um número',
                'exists' => 'O campo ":attribute" deve estar vinculado a um tipo de partida que exista. Pare de mecher no código!',
                'integer' => 'O campo ":attribute" deve ser do tipo integer. Para tal, deve ser um número inteiro menor do que 99999999999'
            ]);

            if($novaPartida) {
                $partida = new Controle_de_tempo();
            }

            $partida->tempo_partida = $request->tempo_partida;
            $partida->tem_incremento = $request->tem_incremento;
            $partida->incremento = $request->incremento;
            $partida->id_tipo_de_partida = $request->id_tipo_de_partida;
            
            if($validator->fails()) {
                $data = [
                    'partida' => $partida,
                    'controles_de_tempo' => Controle_de_tempo::all(),
                    'jogadores' => Jogador::all(),
                    'errors' => $validator->errors()
                ];
                return view('Partidas.partidas_form', $data);
            }
            $partida->save();

            return redirect()->action('Partidas@index')->with('status', $novaPartida? 'O tipo de partida foi criado com sucesso!' : 'As alterações foram salvas!');
        }
        else {
            return view('sem_permissao');
        }
    }
}

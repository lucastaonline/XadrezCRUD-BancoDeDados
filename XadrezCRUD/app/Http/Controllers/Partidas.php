<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Controle_de_tempo;
use App\Partida;
use App\Jogador;
use App\Tipo_de_partida;
use App\Abertura;
use Illuminate\Support\Facades\Validator;
use DateTime;

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
                'controles_de_tempo' => Controle_de_tempo::all(),
                'tipos_de_partida' => Tipo_de_partida::all(),
                'jogadores' => Jogador::all()
            ];
            return view('Partidas.partidas', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function pegarForm(Partida $partida = null) {
        if(Auth::user()->tem_permissao) {
            $data = [
                'partida' => $partida,
                'partidas' => Partida::all(),
                'controles_de_tempo' => Controle_de_tempo::all(),
                'tipos_de_partida' => Tipo_de_partida::all(),
                'jogadores' => Jogador::all(),
                'aberturas' => Abertura::all()
            ];
            return view('Partidas.partidas_form', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function enviarForm(Request $request,Partida $partida = null) {
        if(Auth::user()->tem_permissao) {
            $novaPartida = !isset($partida);
            $deletarPartida = isset($request->delete);
            $vencedorSetado = (isset($request->id_jogador_vencedor)? $request->id_jogador_vencedor != -1 : false);
            $aberturaSetada = (isset($request->id_abertura)? $request->id_abertura != -1 : false);

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
                'id_jogador_brancas' => ['required','integer','different:id_jogador_negras','exists:Jogador,id'],
                'id_jogador_negras' => ['required','integer','different:id_jogador_brancas','exists:Jogador,id'],
                'data_da_partida' => ['required','date','after_or_equal:now'],
                'id_controle_de_tempo' => ['required','integer','exists:Controle_de_tempo,id'],
                'id_jogador_vencedor' => [($vencedorSetado? 'exists:Jogador,id' : ''),($vencedorSetado? 'integer' : '')],
                'id_abertura' => [($aberturaSetada? 'integer' : ''),($aberturaSetada? 'exists:Abertura,id' : '')]
            ],
            [
                'id_jogador_negras.different' => 'O jogador das peças brancas deve ser diferente do jogador das peças negras.',
                'id_jogador_brancas.different' => 'O jogador das peças negras deve ser diferente do jogador das peças brancas.',
                'required' => 'O campo ":attribute" é obrigatório',
                'max' => 'O campo ":attribute" deve ser no máximo :max.',
                'boolean' => 'O valor passado deve ser um booleano. Está bulindo o código espertinho? Passa nada.',
                'number' => 'O campo ":attribute" deve ser um número',
                'id_controle_de_tempo.exists' => 'O campo "Controle de tempo da partida" deve estar vinculado a um controle de tempo que exista. Pare de mecher no código!',
                'id_jogador_brancas.exists' => 'O campo "Jogador das peças brancas" deve estar vinculado a um jogador que exista. Pare de mecher no código!',
                'id_jogador_negras.exists' => 'O campo "Jogador das peças negras" deve estar vinculado a um jogador que exista. Pare de mecher no código!',
                'id_jogador_vencedor.exists' => 'O campo "Jogador vencedor" deve estar vinculado a um jogador que exista. Pare de mecher no código!',
                'id_abertura.exists' => 'O campo ":attribute" deve estar vinculado a uma abertura que exista. Pare de mecher no código!',
                'integer' => 'O campo ":attribute" deve ser do tipo integer. Para tal, deve ser um número inteiro menor do que 99999999999',
                'after_or_equal' => 'A data do jogo deve ser no futuro amigão...'
            ]);

            if($novaPartida) {
                $partida = new Partida();
            }

            $partida->id_jogador_brancas = $request->id_jogador_brancas;
            $partida->id_jogador_negras = $request->id_jogador_negras;
            $partida->data_da_partida = new DateTime($request->data_da_partida);
            $partida->id_controle_de_tempo = $request->id_controle_de_tempo;
            if($vencedorSetado) {
                $partida->id_jogador_vencedor = $request->id_jogador_vencedor;
            }
            if($aberturaSetada) {
                $partida->id_abertura = $request->id_abertura;
            }
            
            if($validator->fails()) {
                $data = [
                    'partida' => $partida,
                    'partidas' => Partida::all(),
                    'controles_de_tempo' => Controle_de_tempo::all(),
                    'tipos_de_partida' => Tipo_de_partida::all(),
                    'jogadores' => Jogador::all(),
                    'aberturas' => Abertura::all(),
                    'errors' => $validator->errors()
                ];

                if($vencedorSetado && new Datetime() < $partida->data_da_partida && !$validator->errors()->has('id_jogador_vencedor')) {
                    $data['errorVencedor'] = 'Você não pode definir o vencedor antes de a partida acontecer espertinho(a)...';
                }
                if($aberturaSetada && new Datetime() < $partida->data_da_partida && !$validator->errors()->has('id_abertura')) {
                    $data['errorAbertura'] = 'Você não pode definir uma abertura antes de a partida acontecer espertinho(a)...';
                }

                return view('Partidas.partidas_form', $data);
            }
            else {
                if($vencedorSetado && new Datetime() < $partida->data_da_partida) {
                    $data = [
                        'partida' => $partida,
                        'partidas' => Partida::all(),
                        'controles_de_tempo' => Controle_de_tempo::all(),
                        'tipos_de_partida' => Tipo_de_partida::all(),
                        'jogadores' => Jogador::all(),
                        'aberturas' => Abertura::all(),
                        'errorVencedor' => 'Você não pode definir o vencedor antes de a partida acontecer espertinho(a)...'
                    ];

                    return view('Partidas.partidas_form', $data);
                }
                else if($aberturaSetada && new Datetime() < $partida->data_da_partida) {
                    $data = [
                        'partida' => $partida,
                        'partidas' => Partida::all(),
                        'controles_de_tempo' => Controle_de_tempo::all(),
                        'tipos_de_partida' => Tipo_de_partida::all(),
                        'jogadores' => Jogador::all(),
                        'aberturas' => Abertura::all(),
                        'errorAbertura' => 'Você não pode definir uma abertura antes de a partida acontecer espertinho(a)...'
                    ];
                    return view('Partidas.partidas_form', $data);
                }
            }
            $partida->save();

            return redirect()->action('Partidas@index')->with('status', $novaPartida? 'A partida foi criado com sucesso!' : 'As alterações foram salvas!');
        }
        else {
            return view('sem_permissao');
        }
    }
}

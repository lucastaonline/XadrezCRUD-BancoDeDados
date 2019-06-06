<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Momento_partida;
use App\Partida;
use App\Lance;
use App\Avaliacao_lance;
use App\Jogador;

class Lances extends Controller
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
                'lances' => Lance::all(),
                'momentos_partida' => Momento_partida::all(),
                'jogadores' =>  Jogador::all(),
                'partidas' => Partida::all(),
                'avaliacoes_lance' => Avaliacao_lance::all()
            ];
            return view('Lances.lances', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function pegarForm(Lance $lance = null) {
        if(Auth::user()->tem_permissao) {

            $data = [
                'lance' => $lance,
                'lances' => Lance::all(),
                'momentos_partida' => Momento_partida::all(),
                'jogadores' =>  Jogador::all(),
                'partidas' => Partida::all(),
                'avaliacoes_lance' => Avaliacao_lance::all()
            ];
            return view('Lances.lances_form', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function enviarForm(Request $request,Lance $lance = null) {
        if(Auth::user()->tem_permissao) {

            $novoLance = !isset($lance);
            $deletarLance = isset($request->delete);

            if($deletarLance) {
                if(!$novoLance) {
                    $lance->delete();
                    return redirect()->action('Lances@index')->with('status', 'O lance foi removido!');
                }
                else {
                    return redirect()->action('Lances@index')->with('badstatus', 'Não é possível remover um lance que não existe. Ta mexendo em código fonte né?');
                }
            }

            $validator = Validator::make($request->all(), [
                'id_jogador' => ['required','integer','exists:Jogador'],
                'id_partida' => ['required','integer','exists:Partida'],
                'id_momento_partida' => ['required','integer','exists:Momento_partida'],
                'id_avaliacao_lance' => ['required','integer','exists:Avaliacao_lance'],
                'numero_lance' => ['required','integer'],
                'mudanca_avaliacao' => ['']
            ],
            [
                'required' => 'O campo ":attribute" é obrigatório',
                'integer' => 'O campo deve enviar um número inteiro para o formulário. Sinto cheiro de alguem bulindo no código...',
                'id_jogador.exists' => 'O jogador selecionado deve existir.',
                'id_partida.exists' => 'A partida selecionada deve existir.',
                'id_momento_partida.exists' => 'O momento de partida selecionado deve existir.',
                'id_avaliacao_lance.exists' => 'A avaliação de lance selecionada deve existir.',
            ]);

            if($novoLance) {
                $lance = new Lance ();
            }

            $lance->id_jogador = $request->id_jogador;
            $lance->id_partida = $request->id_partida;
            $lance->id_momento_partida = $request->id_momento_partida;
            $lance->id_avaliacao_lance = $request->id_avaliacao_lance;
            $lance->numero_partida = $request->numero_partida;
            if(isset($request->mudanca_avaliacao)) {
                $lance->mudanca_avaliacao = $request->mudanca_avaliacao;
            }
            
            if($validator->fails()) {
                $data = [
                    'lance' => $lance,
                    'errors' => $validator->errors(),
                    'lances' => Lance::all(),
                    'momentos_partida' => Momento_partida::all(),
                    'jogadores' =>  Jogador::all(),
                    'partidas' => Partida::all(),
                    'avaliacoes_lance' => Avaliacao_lance::all()
                ];
                return view('Lances.lances_form', $data);
            }

            $lance->save();

            return redirect()->action('Lances@index')->with('status', $novoLance? 'O lance foi criado com sucesso!' : 'As alterações foram salvas!');
        }
        else {
            return view('sem_permissao');
        }
    }
}

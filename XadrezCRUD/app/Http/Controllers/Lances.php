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

use DateTime;

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
                'id_jogador' => ['required','integer','exists:Jogador,id'],
                'id_partida' => ['required','integer','exists:Partida,id'],
                'id_momento_partida' => ['required','integer','exists:Momento_partida,id'],
                'id_avaliacao_lance' => ['required','integer','exists:Avaliacao_lance,id'],
                'numero_lance' => ['required','integer','max:2147483647','min:0'],
                'nivel_avaliacao' => ['required','integer','max:2147483647']
            ],
            [
                'required' => 'O campo ":attribute" é obrigatório',
                'integer' => 'O campo deve enviar um número inteiro para o formulário. Sinto cheiro de alguem bulindo no código...',
                'id_jogador.exists' => 'O jogador selecionado deve existir.',
                'id_partida.exists' => 'A partida selecionada deve existir.',
                'id_momento_partida.exists' => 'O momento de partida selecionado deve existir.',
                'id_avaliacao_lance.exists' => 'A avaliação de lance selecionada deve existir.',
                'max' => 'O campo ":attribute" deve ser do tipo integer. Para tal, deve ser um número inteiro menor do que 2147483647',
                'min' => 'O campo não deve ser menor do que 0.'
            ]);

            if($novoLance) {
                $lance = new Lance ();
            }

            $lance->id_jogador = $request->id_jogador;
            $lance->id_partida = $request->id_partida;
            $lance->id_momento_partida = $request->id_momento_partida;
            $lance->id_avaliacao_lance = $request->id_avaliacao_lance;
            $lance->numero_lance = $request->numero_lance;
            $lance->nivel_avaliacao = $request->nivel_avaliacao;
            
            $partidaDoLance = Partida::all()->firstWhere('id',$lance->id_partida);

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

                if(!$validator->errors()->has('id_jogador') && $lance->id_jogador != $partidaDoLance->id_jogador_brancas && $lance->id_jogador != $partidaDoLance->id_jogador_negras) {
                    $data['errorJogador'] = 'Você deve escolher um jogador que participe da partida né gênio...';
                }
                if (!$validator->errors()->has('id_partida') && new Datetime() < $partidaDoLance->data_da_partida) {
                    $data['errorPartida'] = 'Você não pode definir um lance antes de a partida acontecer espertinho(a)...';
                }

                return view('Lances.lances_form', $data);
            }
            else {
                
                if($lance->id_jogador != $partidaDoLance->id_jogador_brancas && $lance->id_jogador != $partidaDoLance->id_jogador_negras) {
                    $data = [
                        'lance' => $lance,
                        'lances' => Lance::all(),
                        'momentos_partida' => Momento_partida::all(),
                        'jogadores' =>  Jogador::all(),
                        'partidas' => Partida::all(),
                        'avaliacoes_lance' => Avaliacao_lance::all(),
                        'errorJogador' => 'Você deve escolher um jogador que participe da partida né gênio...'
                    ];
                    if(new Datetime() < $partidaDoLance->data_da_partida) {
                        $data['errorPartida'] = 'Você não pode definir um lance antes de a partida acontecer espertinho(a)...';
                    }
                    return view('Lances.lances_form', $data);
                }
                else if(new Datetime() < $partidaDoLance->data_da_partida) {
                    $data = [
                        'lance' => $lance,
                        'lances' => Lance::all(),
                        'momentos_partida' => Momento_partida::all(),
                        'jogadores' =>  Jogador::all(),
                        'partidas' => Partida::all(),
                        'avaliacoes_lance' => Avaliacao_lance::all(),
                        'errorPartida' => 'Você não pode definir um lance antes de a partida acontecer espertinho(a)...'
                    ];
                    return view('Lances.lances_form', $data);
                }
            }

            $lance->save();

            return redirect()->action('Lances@index')->with('status', $novoLance? 'O lance foi criado com sucesso!' : 'As alterações foram salvas!');
        }
        else {
            return view('sem_permissao');
        }
    }
}

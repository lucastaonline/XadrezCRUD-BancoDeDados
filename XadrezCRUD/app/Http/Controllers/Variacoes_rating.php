<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Momento_partida;
use App\Partida;
use App\Variacao_rating;
use App\Jogador;

use DateTime;

class Variacoes_rating extends Controller
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
                'variacoes_rating' => Variacao_rating::all(),
                'jogadores' =>  Jogador::all(),
                'partidas' => Partida::all(),
            ];
            return view('Variacoes_rating.variacoes_rating', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function pegarForm(Variacao_rating $variacao_rating = null) {
        if(Auth::user()->tem_permissao) {

            $data = [
                'variacao_rating' => $variacao_rating,
                'variacoes_rating' => Variacao_rating::all(),
                'jogadores' =>  Jogador::all(),
                'partidas' => Partida::all()
            ];
            return view('Variacoes_rating.variacoes_rating_form', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function enviarForm(Request $request,Variacao_rating $variacao_rating = null) {
        if(Auth::user()->tem_permissao) {

            $novaVariacao_rating = !isset($variacao_rating);
            $deletarVariacao_rating = isset($request->delete);

            if($deletarVariacao_rating) {
                if(!$novaVariacao_rating) {
                    $variacao_rating->delete();
                    return redirect()->action('Variacoes_rating@index')->with('status', 'A variação de rating foi removida!');
                }
                else {
                    return redirect()->action('Variacoes_rating@index')->with('badstatus', 'Não é possível remover uma variação de rating que não existe. Ta mexendo em código fonte né?');
                }
            }

            $validator = Validator::make($request->all(), [
                'id_jogador' => ['required','integer','exists:Jogador,id'],
                'id_partida' => ['required','integer','exists:Partida,id'],
                'variacao' => ['required','integer','max:2147483647']
            ],
            [
                'required' => 'O campo ":attribute" é obrigatório',
                'integer' => 'O campo deve enviar um número inteiro para o formulário. Sinto cheiro de alguem bulindo no código...',
                'id_jogador.exists' => 'O jogador selecionado deve existir.',
                'id_partida.exists' => 'A partida selecionada deve existir.',
                'max' => 'O campo ":attribute" deve ser do tipo integer. Para tal, deve ser um número inteiro menor do que 2147483647'
            ]);

            if($novaVariacao_rating) {
                $variacao_rating = new Variacao_rating();
            }

            $variacao_rating->id_jogador = $request->id_jogador;
            $variacao_rating->id_partida = $request->id_partida;
            $variacao_rating->variacao = $request->variacao;
            
            $partidaDaVariacao = Partida::all()->firstWhere('id',$variacao_rating->id_partida);

            if($validator->fails()) {
                $data = [
                    'variacao_rating' => $variacao_rating,
                    'errors' => $validator->errors(),
                    'variacoes_rating' => Variacao_rating::all(),
                    'jogadores' =>  Jogador::all(),
                    'partidas' => Partida::all()
                ];

                if(!$validator->errors()->has('id_jogador') && $variacao_rating->id_jogador != $partidaDaVariacao->id_jogador_brancas && $variacao_rating->id_jogador != $partidaDaVariacao->id_jogador_negras) {
                    $data['errorJogador'] = 'Você deve escolher um jogador que participe da partida né gênio...';
                }
                if (!$validator->errors()->has('id_partida') && new Datetime() < $partidaDaVariacao->data_da_partida) {
                    $data['errorPartida'] = 'Você não pode definir uma variação de rating antes de a partida acontecer espertinho(a)...';
                }

                return view('Variacoes_rating.variacoes_rating_form', $data);
            }
            else {
                
                if($variacao_rating->id_jogador != $partidaDaVariacao->id_jogador_brancas && $variacao_rating->id_jogador != $partidaDaVariacao->id_jogador_negras) {
                    $data = [
                        'variacao_rating' => $variacao_rating,
                        'variacoes_rating' => Variacao_rating::all(),
                        'jogadores' =>  Jogador::all(),
                        'partidas' => Partida::all(),
                        'errorJogador' => 'Você deve escolher um jogador que participe da partida né gênio...'
                    ];
                    if(new Datetime() < $partidaDaVariacao->data_da_partida) {
                        $data['errorPartida'] = 'Você não pode definir uma variação de rating antes de a partida acontecer espertinho(a)...';
                    }
                    return view('Variacoes_rating.variacoes_rating_form', $data);
                }
                else if(new Datetime() < $partidaDaVariacao->data_da_partida) {
                    $data = [
                        'variacao_rating' => $variacao_rating,
                        'variacoes_rating' => Variacao_rating::all(),
                        'jogadores' =>  Jogador::all(),
                        'partidas' => Partida::all(),
                        'errorPartida' => 'Você não pode definir uma variação de rating antes de a partida acontecer espertinho(a)...'
                    ];
                    return view('Variacoes_rating.variacoes_rating_form', $data);
                }
            }

            $variacao_rating->save();

            return redirect()->action('Variacoes_rating@index')->with('status', $novaVariacao_rating? 'A variação de rating foi criada com sucesso!' : 'As alterações foram salvas!');
        }
        else {
            return view('sem_permissao');
        }
    }
}

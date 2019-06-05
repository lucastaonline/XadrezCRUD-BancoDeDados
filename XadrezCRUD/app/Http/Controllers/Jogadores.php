<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Jogador;
use Illuminate\Support\Facades\Validator;

class Jogadores extends Controller
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
                'jogadores' => Jogador::all()
            ];
            return view('Jogadores.jogadores', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function pegarForm(Jogador $jogador = null) {
        if(Auth::user()->tem_permissao) {

            $data = [
                'jogador' => $jogador,
                'jogadores' => Jogador::all()
            ];
            return view('Jogadores.jogadores_form', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function enviarForm(Request $request,Jogador $jogador = null) {
        if(Auth::user()->tem_permissao) {

            $novoJogador = !isset($jogador);
            $deletarJogador = isset($request->delete);

            if($deletarJogador) {
                if(!$novoJogador) {
                    $jogador->delete();
                    return redirect()->action('Jogadores@index')->with('status', 'O jogador foi removido!');
                }
                else {
                    return redirect()->action('Jogadores@index')->with('badstatus', 'Não é possível remover um jogador que não existe. Ta mexendo em código fonte né?');
                }
            }

            $validator = Validator::make($request->all(), [
                'nome' => ['required','max:50'],
                'rating' => ['required','numeric']
            ],
            [
                'required' => 'O campo ":attribute" é obrigatório',
                'numeric' => 'O campo ":attribute" deve ser um número.',
                'max' => 'O campo ":attribute" deve ter no máximo :max caracteres.'
            ]);

            if($novoJogador) {
                $jogador = new Jogador();
            }

            $jogador->nome = $request->nome;
            $jogador->rating = $request->rating;
            
            if($validator->fails()) {
                $data = [
                    'jogador' => $jogador,
                    'jogadores' => Jogador::all(),
                    'errors' => $validator->errors()
                ];
                return view('Jogadores.jogadores_form', $data);
            }

            $jogador->save();

            return redirect()->action('Jogadores@index')->with('status', $novoJogador? 'O jogador foi criado com sucesso!' : 'As alterações foram salvas!');
        }
        else {
            return view('sem_permissao');
        }
    }
}

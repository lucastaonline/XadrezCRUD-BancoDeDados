<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Momento_partida;

class Momentos_partida extends Controller
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
                'momentos_partida' => Momento_partida::all()
            ];
            return view('Momentos_partida.momentos_partida', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function pegarForm(Momento_partida $momento_partida = null) {
        if(Auth::user()->tem_permissao) {

            $data = [
                'momento_partida' => $momento_partida,
                'momentos_partida' => Momento_partida::all()
            ];
            return view('Momentos_partida.momentos_partida_form', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function enviarForm(Request $request,Momento_partida $momento_partida = null) {
        if(Auth::user()->tem_permissao) {

            $novoMomento_partida = !isset($momento_partida);
            $deletarMomento_partida = isset($request->delete);

            if($deletarMomento_partida) {
                if(!$novoMomento_partida) {
                    $momento_partida->delete();
                    return redirect()->action('Momentos_partida@index')->with('status', 'O momento de partida foi removido!');
                }
                else {
                    return redirect()->action('Momentos_partida@index')->with('badstatus', 'Não é possível remover um momento de partida que não existe. Ta mexendo em código fonte né?');
                }
            }

            $validator = Validator::make($request->all(), [
                'nome' => ['required','max:50','unique:Momento_partida'],
            ],
            [
                'required' => 'O campo ":attribute" é obrigatório',
                'max' => 'O campo ":attribute" deve ter no máximo :max caracteres.',
                'unique' => 'Já existe um momento de partida com esse nome.'
            ]);

            if($novoMomento_partida) {
                $momento_partida = new Momento_partida();
            }

            $momento_partida->nome = $request->nome;
            
            if($validator->fails()) {
                $data = [
                    'momento_partida' => $momento_partida,
                    'errors' => $validator->errors(),
                    'momentos_partida' => Momento_partida::all()
                ];
                return view('Momentos_partida.momentos_partida_form', $data);
            }

            $momento_partida->save();

            return redirect()->action('Momentos_partida@index')->with('status', $novoMomento_partida? 'O momento de partida foi criado com sucesso!' : 'As alterações foram salvas!');
        }
        else {
            return view('sem_permissao');
        }
    }
}

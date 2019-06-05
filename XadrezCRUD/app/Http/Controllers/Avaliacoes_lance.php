<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Avaliacao_lance;

class Avaliacoes_lance extends Controller
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
                'avaliacoes_lance' => Avaliacao_lance::all()
            ];
            return view('Avaliacoes_lance.avaliacoes_lance', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function pegarForm(Avaliacao_lance $avaliacao_lance = null) {
        if(Auth::user()->tem_permissao) {

            $data = [
                'avaliacao_lance' => $avaliacao_lance,
                'avaliacoes_lance' => Avaliacao_lance::all()
            ];
            return view('Avaliacoes_lance.avaliacoes_lance_form', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function enviarForm(Request $request,Avaliacao_lance $avaliacao_lance = null) {
        if(Auth::user()->tem_permissao) {

            $novaAvaliacao_lance = !isset($avaliacao_lance);
            $deletarAvaliacao_lance = isset($request->delete);

            if($deletarAvaliacao_lance) {
                if(!$novaAvaliacao_lance) {
                    $avaliacao_lance->delete();
                    return redirect()->action('Avaliacoes_lance@index')->with('status', 'A avaliação de lance foi removida!');
                }
                else {
                    return redirect()->action('Avaliacoes_lance@index')->with('badstatus', 'Não é possível remover uma avaliação de lance que não existe. Ta mexendo em código fonte né?');
                }
            }

            $validator = Validator::make($request->all(), [
                'nome' => ['required','max:50','unique:Avaliacao_lance'],
            ],
            [
                'required' => 'O campo ":attribute" é obrigatório',
                'max' => 'O campo ":attribute" deve ter no máximo :max caracteres.',
                'unique' => 'Já existe uma avaliação de lance com esse nome.'
            ]);

            if($novaAvaliacao_lance) {
                $avaliacao_lance = new Avaliacao_lance();
            }

            $avaliacao_lance->nome = $request->nome;
            
            if($validator->fails()) {
                $data = [
                    'avaliacao_lance' => $avaliacao_lance,
                    'errors' => $validator->errors(),
                    'avaliacoes_lance' => Avaliacao_lance::all()
                ];
                return view('Avaliacoes_lance.avaliacoes_lance_form', $data);
            }

            $avaliacao_lance->save();

            return redirect()->action('Avaliacoes_lance@index')->with('status', $novaAvaliacao_lance? 'A avaliação de lance foi criada com sucesso!' : 'As alterações foram salvas!');
        }
        else {
            return view('sem_permissao');
        }
    }
}

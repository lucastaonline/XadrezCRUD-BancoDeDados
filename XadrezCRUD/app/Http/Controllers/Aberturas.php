<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Abertura;

class Aberturas extends Controller
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
                'aberturas' => Abertura::all()
            ];
            return view('Aberturas.aberturas', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function pegarForm(Abertura $abertura = null) {
        if(Auth::user()->tem_permissao) {

            $data = [
                'abertura' => $abertura,
                'aberturas' => Abertura::all()
            ];
            return view('Aberturas.aberturas_form', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function enviarForm(Request $request,Abertura $abertura = null) {
        if(Auth::user()->tem_permissao) {

            $novaAbertura = !isset($abertura);
            $deletarAbertura = isset($request->delete);

            if($deletarAbertura) {
                if(!$novaAbertura) {
                    $abertura->delete();
                    return redirect()->action('Aberturas@index')->with('status', 'A abertura foi removida!');
                }
                else {
                    return redirect()->action('Aberturas@index')->with('badstatus', 'Não é possível remover uma abertura que não existe. Ta mexendo em código fonte né?');
                }
            }

            $validator = Validator::make($request->all(), [
                'nome' => ['required','max:50','unique:Abertura'],
            ],
            [
                'required' => 'O campo ":attribute" é obrigatório',
                'max' => 'O campo ":attribute" deve ter no máximo :max caracteres.',
                'unique' => 'Já existe uma abertura com esse nome.'
            ]);

            if($novaAbertura) {
                $abertura = new Abertura();
            }

            $abertura->nome = $request->nome;
            
            if($validator->fails()) {
                $data = [
                    'abertura' => $abertura,
                    'errors' => $validator->errors(),
                    'aberturas' => Abertura::all()
                ];
                return view('Aberturas.aberturas_form', $data);
            }

            $abertura->save();

            return redirect()->action('Aberturas@index')->with('status', $novaAbertura? 'A abertura foi criada com sucesso!' : 'As alterações foram salvas!');
        }
        else {
            return view('sem_permissao');
        }
    }
}

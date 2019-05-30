<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;

class Usuarios extends Controller
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
                'users' => User::all()
            ];
            return view('Usuarios.usuarios', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function pegarForm(User $user) {
        if(Auth::user()->tem_permissao) {
            $data = [
                'user' => $user
            ];
            return view('Usuarios.usuarios_form', $data);
        }
        else {
            return view('sem_permissao');
        }
    }

    public function enviarForm(Request $request,User $user) {
        if(Auth::user()->tem_permissao) {
            if(isset($request->delete)) {
                $user->delete();
                return redirect()->action('Usuarios@index')->with('status', 'O usuário foi removido!');
            }

            $user->name = $request->nome;
            $user->email = $request->email;
            if(isset($request->tem_permissao))
                $user->tem_permissao = true;
            else
                $user->tem_permissao = false;
            $validator = Validator::make($request->all(), [
                'nome' => ['required','max:255'],
                'email' => ['required','email']
            ],
            [
                'required' => 'O atributo :attribute é obrigatório',
                'email' => 'O ID passado não pertence a nenhum usuário.',
                'max' => 'O atributo ":attribute" deve ter no máximo :max caracteres.'
            ]);
            if($validator->fails()) {
                $data = [
                    'user' => $user,
                    'errors' => $validator->errors()
                ];
                return view('Usuarios.usuarios_form', $data);
            }
            $user->save();
            return redirect()->action('Usuarios@index')->with('status', 'As alterações foram salvas!');
        }
        else {
            return view('sem_permissao');
        }
    }
}

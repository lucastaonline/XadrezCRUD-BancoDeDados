<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

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

    public function enviarForm(Request $request) {
        if(Auth::user()->tem_permissao) {
            $data = [
                'users' => User::find($request->user_id)
            ];
            return view('Usuarios.usuarios', $data);
        }
        else {
            return view('sem_permissao');
        }
    }
}

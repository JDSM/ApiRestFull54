<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;


class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        $user = User::all();
        return $this->showAll ($user);
    }
   
    public function store (Request $request)
    {
        //almacena todos los datos que viajan por url
        $campos= $request->all ();
        //reglas de validacion
        $reglas = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        $this->validate ($request,$reglas);
        
        $campos['password'] = bcrypt($request->password);
        $campos['verified'] = User::USUARIO_NO_VERIFICADO;
        $campos['verication_token'] = User::generarVerificationToken();
        $campos['admin'] = User::USUARIO_REGULAR;

        $user = User::create ($campos);

        return $this->showOne ($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    //public function show($id)//
    public function show (User $user)
    {
      //  $usuario = User::findOrFail($id); // al modificar show ($id) se valida directamente en la funcion 
        return $this->showOne ($user);
    }

 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request, User $user)
    {
        //$user = User::findOrFail($id);

         //reglas de validacion
         $reglas = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR,
        ];
        
        $this->validate ($request, $reglas);

        if($request->has ('name')) {
            $user->name = $request->name;
        }

        if ($request->has ('email') && $user->email != $request->email) {
            
            $user->verified = User::USUARIO_NO_VERIFICADO;
            $user->verification_token = User::generarVerificationToken ();
            $user->email = $request->email; 
        }

        if ($request->has ('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->has ('admin')) {
            if (!$user->esVerificado ()){
                return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su valor de administrador', 409);
            }

            $user->admin = $request->admin;
        }

        if (!$user->isDirty()) {
            return $this->errorResponse ('Se debe modificar almenos un valor para actualizar', 422);
        }

        $user->save ();

        return $this->showOne ($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy (User $user)
    {
       // $user = User::findOrFail($id);

        $user->delete ();
        
        return $this->showOne ($user);
    }

    public function verify($token) {
        $user = User::where('verification_token', $token)->firstOrFail();

        $user->verified = User::USUARIO_VERIFICADO;

        $user->verification_token = null;

        $user->save();

        return $this->showMessage('La cuenta ha sido verificada');
    }
}

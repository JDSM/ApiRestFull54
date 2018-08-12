<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes ;

    const USUARIO_VERIFICADO = '1';
    const USUARIO_NO_VERIFICADO = '0';

    const USUARIO_ADMINISTRADOR = 'true';
    const USUARIO_REGULAR = 'false';

    protected $table = 'users';
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];

    //Bloque Mutador cambia el valor a minusculas
    public function setNameAttribute($valor) {
        $this->attributes['name'] = strtolower($valor);
    }

    //Bloque Mutador cambia el valor a minusculas
    public function setEmailAttribute ($valor) {
        $this->attributes['email'] = strtolower($valor);
    }

    //bloque Accesor coloca en mayuscula la primera letra pero solo para consulta
    public function getNameAttribute ($valor) {
        return ucfirst($valor);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];
    public function esVerificado()
    {
        return $this->verified == User::USUARIO_VERIFICADO;
    }
    public function esAdministrador()
    {
        return $this->admin == User::USUARIO_ADMINISTRADOR;
    }
    public static function generarVerificationToken()
    {
        return str_random(40);
    }
}

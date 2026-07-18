<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Socio extends Model
{
    use HasFactory;

    protected $table = 'socios';

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'email',
        'telefono',
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'socio_id');
    }
}

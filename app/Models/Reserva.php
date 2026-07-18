<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'socio_id',
        'libro_id',
        'fecha_reserva',
        'fecha_devolucion',
        'estado',
    ];

    protected $casts = [
        'fecha_reserva'    => 'date',
        'fecha_devolucion' => 'date',
    ];

    public function socio()
    {
        return $this->belongsTo(Socio::class, 'socio_id');
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }
}

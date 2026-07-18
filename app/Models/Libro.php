<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Libro extends Model
{
    use HasFactory;

    protected $table = 'libros';

    protected $fillable = [
        'titulo',
        'descripcion',
        'paginas',
        'stock',
        'fecha_publicacion',
        'idioma',
    ];

    protected $casts = [
        'fecha_publicacion' => 'date',
        'paginas'           => 'integer',
        'stock'             => 'integer',
    ];

    public function autores()
    {
        return $this->belongsToMany(
            Autor::class,
            'autorias',
            'libro_id',
            'autor_id'
        );
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'libro_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autoria extends Model
{
    protected $table = 'autorias';

    protected $fillable = [
        'autor_id',
        'libro_id',
    ];

    public function autores()
    {
        return $this->belongsTo(Autor::class);
    }

    public function libros()
    {
        return $this->belongsTo(Libro::class);
    }
}
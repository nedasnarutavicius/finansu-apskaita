<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Irasas extends Model
{
    use HasFactory;

    protected $table = 'irasai'; // 👈 ŠITAS svarbiausia

    protected $fillable = [
        'user_id',
        'kategorija_id',
        'tipas_id',
        'suma',
        'aprasymas',
        'data',
    ];

    public function vartotojas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategorija()
    {
        return $this->belongsTo(Kategorija::class, 'kategorija_id');
    }

    public function tipas()
    {
        return $this->belongsTo(Tipas::class, 'tipas_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageModal extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'iso_639_1',
    ];
    protected $table;
    public $timestamps = false;

    public function __construct()
    {
        $this->table = 'languages';
    }
}

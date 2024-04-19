<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoresBooks extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'store_id'
    ];

    public function store($data) {
        $instance = $this->newInstance($data);
        $instance->save();
        
        return $instance;
    }
}

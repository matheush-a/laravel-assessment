<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Store extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'address',
        'active',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'stores_books', 'store_id', 'book_id');
    }

    public function store($data) 
    {
        $instance = $this->newInstance($data);
        $instance->save();
        
        return $instance;
    }

    public function updateStore($store, $data) {
        $store->fill($data);
        $store->save();
        
        return $store;
    }
}

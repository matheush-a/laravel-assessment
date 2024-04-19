<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'isbn',
        'value',
    ];

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class, 'stores_books', 'book_id', 'store_id');
    }

    public function store($data) 
    {
        $instance = $this->newInstance($data);
        $instance->save();
        
        return $instance;
    }

    public function updateBook($book, $data) {
        $book->fill($data);
        $book->save();
        
        return $book;
    }
}

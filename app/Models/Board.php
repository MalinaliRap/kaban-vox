<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'created_by', 'updated_by'];

    // Relacionamento com categories
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    // Relacionamento com o usuário que criou o board
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relacionamento com o usuário que atualizou o board
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description', 'category_id', 'created_by', 'updated_by'];

    // Relacionamento com a categoria
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relacionamento com o usuário que criou a task
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relacionamento com o usuário que atualizou a task
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

<?php

// app/Models/Category.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Task;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'board_id', 'created_by', 'updated_by'];

    // Relacionamento com o board
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    // Relacionamento com as tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Relacionamento com o usuário que criou a categoria
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relacionamento com o usuário que atualizou a categoria
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

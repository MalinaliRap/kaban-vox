<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
     // Exibir todas as categorias de um board
    public function index($boardId)
    {
        $board = Board::findOrFail($boardId);
        $categories = $board->categories; // Obtém as categorias associadas ao board
        return response()->json($categories);
    }

    // Exibir uma categoria específica
    public function show($boardId, $categoryId)
    {
        $board = Board::findOrFail($boardId);
        $category = $board->categories()->findOrFail($categoryId);
        return response()->json($category);
    }

    // Criar uma nova categoria
    public function store(Request $request, $boardId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $board = Board::findOrFail($boardId);
        $category = new Category();
        $category->name = $request->name;
        $category->board_id = $board->id;
        $category->created_by = Auth::id(); // Usuário autenticado
        $category->updated_by = Auth::id(); // Usuário autenticado
        $category->save();

        return response()->json($category, 201);
    }

    // Atualizar uma categoria
    public function update(Request $request, $boardId, $categoryId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $board = Board::findOrFail($boardId);
        $category = $board->categories()->findOrFail($categoryId);
        $category->name = $request->name;
        $category->updated_by = Auth::id(); // Usuário autenticado
        $category->save();

        return response()->json($category);
    }

    // Deletar (soft delete) uma categoria
    public function destroy($categoryId)
    {
        $category = Category::with('tasks')->findOrFail($categoryId);
        if(!empty($category->tasks)){
            return response()->json(['message' => 'Categoria possui tarefas, exclua-las primeiro'], 400);
        }
        $category->delete(); // Soft delete

        return response()->json(['message' => 'Categoria deletada com sucesso']);
    }
}

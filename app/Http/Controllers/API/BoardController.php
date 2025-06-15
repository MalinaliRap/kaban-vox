<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LDAP\Result;

class BoardController extends Controller
{

 // Exibir todos os boards
    public function index()
    {
        $boards = Board::all(); // Pode adicionar filtros ou ordenação, conforme necessário
        return view('boards.index', compact('boards'));
    }

    public function kanban($id) {
        $board = Board::with('categories')->findOrFail($id);
        return view('kanban.index', compact('board'));
    }

    // Exibir um board específico
    public function show($id)
    {
        $board = Board::findOrFail($id);
        return response()->json($board);
    }

    // Criar um novo board
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $board = new Board();
        $board->name = $request->name;
        $board->description = $request->description;
        $board->created_by = Auth::id(); // Usuário autenticado
        $board->updated_by = Auth::id(); // Usuário autenticado
        $board->save();

        return response()->json($board, 201);
    }

    // Atualizar um board
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $board = Board::findOrFail($id);
        $board->name = $request->name;
        $board->description = $request->description;
        $board->updated_by = Auth::id(); // Usuário autenticado
        $board->save();

        return response()->json($board);
    }

    // Deletar (soft delete) um board
    public function destroy($id)
    {
        $board = Board::findOrFail($id);
        $board->delete(); // Realiza o soft delete

        return response()->json(['message' => 'Board deleted successfully']);
    }
}

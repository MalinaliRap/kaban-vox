<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskController extends Controller
{
   // Exibir todas as tarefas de uma categoria
    public function index($boardId, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $tasks = $category->tasks; // Obtém as tarefas associadas à categoria
        return response()->json($tasks);
    }

    // Exibir uma tarefa específica
    public function show($taskId)
    {
        $task = Task::findOrFail($taskId);
        return response()->json($task);
    }

    // Criar uma nova tarefa
    public function store(Request $request, $categoryId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($categoryId);
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->category_id = $category->id;
        $task->created_by = Auth::id(); // Usuário autenticado
        $task->updated_by = Auth::id(); // Usuário autenticado
        $task->save();

        return response()->json($task, 201);
    }

    // Atualizar uma tarefa
    public function update(Request $request, $taskId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);


        $task = Task::findOrFail($taskId);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->updated_by = Auth::id(); // Usuário autenticado
        $task->save();

        return response()->json($task);
    }

    // Deletar (soft delete) uma tarefa
    public function destroy($taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->delete(); // Soft delete

        return response()->json(['message' => 'Tarefa deletada com sucesso']);
    }

    public function move(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->category_id = $request->input('category_id');
        $task->save();

        return response()->json(['success' => true]);
    }

}

<div class="list-group-item my-3 kanban-task d-flex justify-content-between align-items-center" data-task-id="{{ $task->id }}">
    <div>
        <h5 class="card-title mb-1">{{ $task->title }}</h5>
        <p class="card-text mb-0">{{ $task->description }}</p>
    </div>
    <button class="btn btn-outline-danger btn-sm delete-task-button">
        <i class="fas fa-trash"></i>
    </button>
</div>

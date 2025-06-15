    <div class="kanban-card col-3 p-3" data-board-id="{{ $board->id }}">
        <h5>{{ $board->name }}</h5>
        <div class="list-group">
            <div class="list-group-item">
                {{ $board->description }}
            </div>
            <div class="list-group-item">
                <button class="btn btn-primary" id="viewBoardButton">
                    <i class="bi bi-eye"></i>
                </button>
                <button class="btn btn-danger deleteBoardButton" data-board-id="{{ $board->id }}">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    </div>

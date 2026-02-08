<?php
// Definição de cores por prioridade
$priorityColors = [
    'low' => 'bg-green-100 text-green-800 border-green-200',
    'medium' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
    'high' => 'bg-red-100 text-red-800 border-red-200'
];
$priorityLabels = [
    'low' => 'Baixa',
    'medium' => 'Média',
    'high' => 'Alta'
];

$pColor = $priorityColors[$task['priority']] ?? 'bg-gray-100 text-gray-800';
$pLabel = $priorityLabels[$task['priority']] ?? 'Normal';
?>

<div id="task-<?= $task['id'] ?>" draggable="true" ondragstart="drag(event)"
    class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-3 cursor-move hover:shadow-md transition-shadow duration-200 group relative">

    <div
        class="absolute top-2 right-2 flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
        <?php if ($task['status'] !== 'done'): ?>
            <button onclick='openEditTask(<?= json_encode($task) ?>)' class="text-gray-300 hover:text-primary p-1"
                title="Editar Tarefa">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </button>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>/tasks/delete/<?= $task['id'] ?>?work_id=<?= $work['id'] ?>"
            onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')"
            class="text-gray-300 hover:text-red-500 p-1" title="Excluir Tarefa">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </a>
    </div>

    <div class="flex items-center justify-between mb-2">
        <span class="text-xs px-2 py-0.5 rounded-md font-medium border <?= $pColor ?>">
            <?= $pLabel ?>
        </span>
        <?php if ($task['deadline']): ?>
            <span
                class="text-xs text-gray-500 flex items-center <?= (strtotime($task['deadline']) < time() && $task['status'] != 'done') ? 'text-red-500 font-bold' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <?= date('d/m', strtotime($task['deadline'])) ?>
            </span>
        <?php endif; ?>
    </div>

    <h4 class="font-bold text-gray-800 mb-1">
        <?= htmlspecialchars($task['title']) ?>
    </h4>

    <?php if ($task['description']): ?>
        <p class="text-xs text-gray-500 mb-3 line-clamp-2">
            <?= htmlspecialchars($task['description']) ?>
        </p>
    <?php endif; ?>

    <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-50">
        <div class="flex items-center">
            <?php if ($task['responsible_name']): ?>
                <div class="h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center text-xs text-primary font-bold mr-2"
                    title="<?= htmlspecialchars($task['responsible_name']) ?>">
                    <?= strtoupper(substr($task['responsible_name'], 0, 1)) ?>
                </div>
                <span class="text-xs text-gray-600 truncate max-w-[100px]">
                    <?= htmlspecialchars($task['responsible_name']) ?>
                </span>
            <?php else: ?>
                <span class="text-xs text-gray-400 italic">Sem responsável</span>
            <?php endif; ?>
        </div>
    </div>
</div>
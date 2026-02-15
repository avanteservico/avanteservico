<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">

    <!-- Header -->
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <a href="<?= BASE_URL ?>/works/show/<?= $work['id'] ?>"
                class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">&larr; Voltar para Obra</a>
            <h1 class="text-2xl font-bold text-gray-900">Quadro de Tarefas (Kanban)</h1>
            <p class="text-gray-500">
                <?= htmlspecialchars($work['name']) ?>
            </p>
        </div>
        <button onclick="document.getElementById('modal-task').classList.remove('hidden')"
            class="mt-4 md:mt-0 bg-primary hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow-md transition-colors duration-200 flex items-center text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nova Tarefa
        </button>
    </div>

    <!-- Kanban Board -->
    <div class="flex flex-col md:flex-row gap-6 overflow-x-auto pb-4">

        <!-- Column: A Fazer (todo) -->
        <div class="flex-1 min-w-[300px]">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-700 uppercase tracking-wide text-sm flex items-center">
                    <span class="w-3 h-3 bg-gray-400 rounded-full mr-2"></span>
                    A Fazer
                </h3>
                <span class="bg-gray-200 text-gray-600 text-xs px-2 py-1 rounded-full font-bold">
                    <?= count($tasks['todo']) ?>
                </span>
            </div>

            <div class="bg-gray-100 rounded-xl p-3 min-h-[500px]" ondrop="drop(event, 'todo')"
                ondragover="allowDrop(event)">

                <?php foreach ($tasks['todo'] as $task): ?>
                    <?php include 'card.php'; ?>
                <?php endforeach; ?>

                <?php if (empty($tasks['todo'])): ?>
                    <div class="text-center py-8 text-gray-400 text-sm border-2 border-dashed border-gray-300 rounded-lg">
                        Arraste tarefas aqui
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Column: Em Andamento (doing) -->
        <div class="flex-1 min-w-[300px]">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-blue-600 uppercase tracking-wide text-sm flex items-center">
                    <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                    Em Andamento
                </h3>
                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-bold">
                    <?= count($tasks['doing']) ?>
                </span>
            </div>

            <div class="bg-blue-50 rounded-xl p-3 min-h-[500px]" ondrop="drop(event, 'doing')"
                ondragover="allowDrop(event)">

                <?php foreach ($tasks['doing'] as $task): ?>
                    <?php include 'card.php'; ?>
                <?php endforeach; ?>

            </div>
        </div>

        <!-- Column: Concluído (done) -->
        <div class="flex-1 min-w-[300px]">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-green-600 uppercase tracking-wide text-sm flex items-center">
                    <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                    Concluído
                </h3>
                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-bold">
                    <?= count($tasks['done']) ?>
                </span>
            </div>

            <div class="bg-green-50 rounded-xl p-3 min-h-[500px]" ondrop="drop(event, 'done')"
                ondragover="allowDrop(event)">

                <?php foreach ($tasks['done'] as $task): ?>
                    <?php include 'card.php'; ?>
                <?php endforeach; ?>

            </div>
        </div>

    </div>
</div>

<!-- Modal Create Task -->
<div id="modal-task" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="<?= BASE_URL ?>/tasks/create" method="POST">
                <input type="hidden" name="work_id" value="<?= $work['id'] ?>">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Nova Tarefa</h3>

                    <div class="mt-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Título</label>
                            <input type="text" name="title" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Prioridade</label>
                                <select name="priority"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <option value="low">Baixa</option>
                                    <option value="medium" selected>Média</option>
                                    <option value="high">Alta</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Prazo</label>
                                <input type="date" name="deadline"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Responsável</label>
                            <select name="responsible_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                <option value="">Selecione...</option>
                                <?php
                                // Precisamos carregar as pessoas no controller
                                $personModel = new Person();
                                $people = $personModel->getAll(); // Idealmente filtrar apenas disponiveis ou algo assim, mas ok por agora
                                foreach ($people as $p):
                                    ?>
                                    <option value="<?= $p['id'] ?>">
                                        <?= htmlspecialchars($p['name']) ?> (
                                        <?= htmlspecialchars($p['role']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea name="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-blue-800 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Criar
                        Tarefa</button>
                    <button type="button" onclick="document.getElementById('modal-task').classList.add('hidden')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Task -->
<div id="modal-edit-task" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="<?= BASE_URL ?>/tasks/update" method="POST">
                <input type="hidden" name="id" id="edit-task-id">
                <input type="hidden" name="work_id" value="<?= $work['id'] ?>">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Editar Tarefa</h3>

                    <div class="mt-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Título</label>
                            <input type="text" name="title" id="edit-task-title" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Prioridade</label>
                                <select name="priority" id="edit-task-priority"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <option value="low">Baixa</option>
                                    <option value="medium">Média</option>
                                    <option value="high">Alta</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Prazo</label>
                                <input type="date" name="deadline" id="edit-task-deadline"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Responsável</label>
                            <select name="responsible_id" id="edit-task-responsible"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                <option value="">Selecione...</option>
                                <?php foreach ($people as $p): ?>
                                    <option value="<?= $p['id'] ?>">
                                        <?= htmlspecialchars($p['name']) ?> (<?= htmlspecialchars($p['role']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea name="description" id="edit-task-description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-blue-800 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Salvar
                        Alterações</button>
                    <button type="button" onclick="document.getElementById('modal-edit-task').classList.add('hidden')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditTask(task) {
        document.getElementById('edit-task-id').value = task.id;
        document.getElementById('edit-task-title').value = task.title;
        document.getElementById('edit-task-priority').value = task.priority;
        document.getElementById('edit-task-deadline').value = task.deadline || '';
        document.getElementById('edit-task-responsible').value = task.responsible_id || '';
        document.getElementById('edit-task-description').value = task.description || '';

        document.getElementById('modal-edit-task').classList.remove('hidden');
    }

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev, status) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        var el = document.getElementById(data);

        // Find the drop target container (div with ondrop)
        var targetContainer = ev.target;
        while (!targetContainer.hasAttribute('ondrop')) {
            targetContainer = targetContainer.parentElement;
        }

        targetContainer.appendChild(el);

        // Update status via AJAX
        var taskId = data.replace('task-', '');

        fetch('<?= BASE_URL ?>/tasks/updateStatus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id: taskId,
                status: status
            })
        })
            .then(response => response.text())
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if (!data.success) {
                        alert('Erro ao atualizar status: ' + (data.message || 'Erro desconhecido'));
                        location.reload();
                    }
                } catch (e) {
                    console.error('Erro ao processar resposta do servidor:', text);
                    alert('Erro de comunicação com o servidor. Verifique o console para mais detalhes.');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Erro de conexão ou rede.');
            });
    }
</script>
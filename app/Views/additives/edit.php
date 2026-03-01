<div class="max-w-2xl mx-auto px-4 py-8 mb-20">
    <div class="mb-8">
        <a href="<?= BASE_URL ?>/additives?work_id=<?= $work['id'] ?>"
            class="flex items-center text-gray-500 hover:text-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Voltar para Aditivos
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-4">Editar Aditivo</h1>
        <p class="text-sm text-gray-500">Obra: <strong>
                <?= htmlspecialchars($work['name']) ?>
            </strong></p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="<?= BASE_URL ?>/additives/update" method="POST" class="p-6 space-y-6">
            <input type="hidden" name="id" value="<?= $additive['id'] ?>">
            <input type="hidden" name="work_id" value="<?= $work['id'] ?>">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome do Aditivo *</label>
                <input type="text" name="name" id="name" required
                    class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50"
                    placeholder="Ex: Acréscimo de Obra Civil..." value="<?= htmlspecialchars($additive['name']) ?>">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descrição
                    (opcional)</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50"
                    placeholder="Descreva o motivo ou detalhes..."><?= htmlspecialchars($additive['description'] ?? '') ?></textarea>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Situação</label>
                <?php if (!empty($subAdditives)): ?>
                    <p class="text-xs text-teal-600 mb-1 italic">
                        A situação é atualizada automaticamente com base nas subetapas.
                    </p>
                <?php endif; ?>
                <select name="status" id="status"
                    class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 <?= !empty($subAdditives) ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' ?>"
                    <?= !empty($subAdditives) ? 'disabled' : '' ?>>
                    <option value="pendente" <?= $additive['status'] == 'pendente' ? 'selected' : '' ?>>Pendente</option>
                    <option value="finalizado" <?= $additive['status'] == 'finalizado' ? 'selected' : '' ?>>Finalizado
                    </option>
                </select>
                <?php if (!empty($subAdditives)): ?>
                    <!-- Campo oculto para enviar o valor mesmo com select disabled -->
                    <input type="hidden" name="status" value="<?= htmlspecialchars($additive['status']) ?>">
                <?php endif; ?>
            </div>

            <!-- Subetapas existentes (visualização) -->
            <?php if (!empty($subAdditives)): ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subetapas cadastradas</label>
                    <ul class="space-y-1">
                        <?php foreach ($subAdditives as $sub): ?>
                            <li class="flex items-center justify-between text-sm text-gray-600 bg-gray-50 rounded px-3 py-2">
                                <span>
                                    <?= htmlspecialchars($sub['name']) ?>
                                </span>
                                <span
                                    class="text-xs px-2 py-0.5 rounded font-medium <?= $sub['status'] == 'finalizado' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
                                    <?= ucfirst($sub['status']) ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="pt-4 flex items-center justify-between">
                <!-- Botão Excluir (à esquerda) -->
                <a href="<?= BASE_URL ?>/additives/delete/<?= $additive['id'] ?>"
                    onclick="return confirm('Excluir este aditivo e todas as suas subetapas?')"
                    class="px-4 py-2 border border-red-300 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 focus:outline-none">
                    Excluir Aditivo
                </a>

                <div class="flex items-center space-x-4">
                    <a href="<?= BASE_URL ?>/additives?work_id=<?= $work['id'] ?>"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">Cancelar</a>
                    <button type="submit"
                        class="px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg text-sm font-medium shadow-md focus:outline-none">
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
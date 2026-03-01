<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">

    <!-- Header -->
    <div class="mb-6">
        <a href="<?= BASE_URL ?>/works/show/<?= $work['id'] ?>"
            class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">&larr; Voltar para Obra</a>
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Aditivos da Obra</h1>
                <p class="text-gray-500">
                    <?= htmlspecialchars($work['name']) ?>
                </p>
            </div>
            <a href="<?= BASE_URL ?>/additives/create?work_id=<?= $work['id'] ?>"
                class="bg-primary hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow-md transition-colors duration-200 flex items-center text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Novo Aditivo
            </a>
        </div>
    </div>

    <!-- Aviso informativo -->
    <div class="bg-teal-50 border border-teal-200 rounded-lg px-4 py-3 mb-6 flex items-start space-x-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mt-0.5 flex-shrink-0" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-sm text-teal-700">Os aditivos são registros documentais da obra e <strong>não impactam os valores
                financeiros da obra</strong>. Use para registrar acréscimos de escopo, alterações contratuais ou outras
            informações relevantes.</p>
    </div>

    <!-- Lista de Aditivos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Etapa
                        </th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Valor
                            a Pagar</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">%
                            Executado</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Valor
                            Devido</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Valor
                            Recebido</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                            Situação</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Ações
                        </th>
                    </tr>
                </thead>
                <?php if (empty($additives)): ?>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-gray-500">Nenhum aditivo cadastrado.</td>
                        </tr>
                    </tbody>
                <?php else: ?>
                    <?php
                    $totals = ['value' => 0, 'valor_devido' => 0, 'paid_value' => 0];
                    foreach ($additives as $additive):
                        $valor_devido = $additive['value'] * ($additive['executed_percentage'] / 100);
                        $totals['value'] += $additive['value'];
                        $totals['valor_devido'] += $valor_devido;
                        $totals['paid_value'] += $additive['paid_value'];
                        ?>
                        <tbody x-data="{ open: false }" class="divide-y divide-gray-100 border-b border-gray-100">
                            <!-- Linha do Aditivo Principal -->
                            <tr class="bg-white hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <button @click="open = !open"
                                            class="mr-2 text-gray-400 hover:text-teal-600 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 transform transition-transform" :class="{'rotate-90': open}"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                        <span class="font-bold text-gray-900"><?= htmlspecialchars($additive['name']) ?></span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm text-gray-900 font-medium">
                                    R$ <?= number_format($additive['value'], 2, ',', '.') ?>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm text-gray-600">
                                    <?= number_format($additive['executed_percentage'], 2, ',', '.') ?>%
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm text-blue-600 font-bold">
                                    R$ <?= number_format($valor_devido, 2, ',', '.') ?>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm text-green-600 font-bold">
                                    R$ <?= number_format($additive['paid_value'], 2, ',', '.') ?>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $additive['status'] == 'finalizado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                        <?= ucfirst($additive['status']) ?>
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <button
                                            onclick="document.getElementById('modal-sub-<?= $additive['id'] ?>').classList.remove('hidden')"
                                            class="text-xs text-teal-600 hover:underline" title="Adicionar Subetapa">
                                            + Etapa
                                        </button>
                                        <a href="<?= BASE_URL ?>/additives/edit/<?= $additive['id'] ?>"
                                            class="text-gray-400 hover:text-teal-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <a href="<?= BASE_URL ?>/additives/delete/<?= $additive['id'] ?>"
                                            onclick="return confirm('Excluir este aditivo e todas as suas subetapas?')"
                                            class="text-red-400 hover:text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- Subetapas (accordion) -->
                            <?php foreach ($additive['sub_additives'] as $sub): ?>
                                <tr x-show="open" class="bg-gray-50 bg-opacity-50 hover:bg-gray-100 transition-colors">
                                    <td class="px-4 py-2 pl-10 whitespace-nowrap" colspan="5">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 rounded-full bg-teal-300 mr-2"></div>
                                            <span
                                                class="text-xs text-gray-600 font-medium"><?= htmlspecialchars($sub['name']) ?></span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <span
                                            class="text-[10px] uppercase px-1.5 py-0.5 rounded font-bold <?= $sub['status'] == 'finalizado' ? 'bg-green-50 text-green-700' : 'bg-yellow-50 text-yellow-700' ?>">
                                            <?= $sub['status'] == 'finalizado' ? 'OK' : '...' ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-right text-xs">
                                        <div class="flex items-center justify-end space-x-2">
                                            <button onclick='openEditSubAdditive(<?= json_encode($sub) ?>)'
                                                class="text-teal-500 hover:text-teal-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <a href="<?= BASE_URL ?>/additives/deleteSubAdditive/<?= $sub['id'] ?>?work_id=<?= $work['id'] ?>"
                                                onclick="return confirm('Excluir esta subetapa?')"
                                                class="text-red-400 hover:text-red-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <!-- Modal Adicionar Subetapa -->
                            <div id="modal-sub-<?= $additive['id'] ?>" class="fixed inset-0 z-50 overflow-y-auto hidden"
                                aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div
                                    class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true">
                                    </div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                        aria-hidden="true">&#8203;</span>
                                    <div
                                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <form action="<?= BASE_URL ?>/additives/createSubAdditive" method="POST">
                                            <input type="hidden" name="additive_id" value="<?= $additive['id'] ?>">
                                            <input type="hidden" name="work_id" value="<?= $work['id'] ?>">
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-1">Nova Subetapa</h3>
                                                <p class="text-sm text-gray-500 mb-4">Para:
                                                    <?= htmlspecialchars($additive['name']) ?>
                                                </p>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Nome</label>
                                                    <input type="text" name="name" required
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <button type="submit"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Salvar</button>
                                                <button type="button"
                                                    onclick="document.getElementById('modal-sub-<?= $additive['id'] ?>').classList.add('hidden')"
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tbody>
                    <?php endforeach; ?>

                    <!-- Linha de Totais -->
                    <tbody class="divide-y divide-gray-200">
                        <tr class="bg-gray-100 font-bold">
                            <td class="px-4 py-4 whitespace-nowrap text-gray-900 text-sm">TOTAIS</td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm text-gray-900">
                                R$ <?= number_format($totals['value'], 2, ',', '.') ?>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm text-gray-500">-</td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm text-blue-700">
                                R$ <?= number_format($totals['valor_devido'], 2, ',', '.') ?>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm text-green-700">
                                R$ <?= number_format($totals['paid_value'], 2, ',', '.') ?>
                            </td>
                            <td class="px-4 py-4"></td>
                            <td class="px-4 py-4"></td>
                        </tr>
                    </tbody>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

<!-- Modal Editar Subetapa -->
<div id="modal-edit-sub" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-edit-title"
    role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="<?= BASE_URL ?>/additives/updateSubAdditive" method="POST">
                <input type="hidden" name="id" id="edit-sub-id">
                <input type="hidden" name="additive_id" id="edit-sub-additive-id">
                <input type="hidden" name="work_id" value="<?= $work['id'] ?>">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-edit-title">Editar Subetapa</h3>
                    <div class="mt-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" name="name" id="edit-sub-name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Situação</label>
                            <select name="status" id="edit-sub-status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                                <option value="pendente">Pendente</option>
                                <option value="finalizado">Finalizado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Salvar
                        Alterações</button>
                    <button type="button" onclick="document.getElementById('modal-edit-sub').classList.add('hidden')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditSubAdditive(sub) {
        document.getElementById('edit-sub-id').value = sub.id;
        document.getElementById('edit-sub-additive-id').value = sub.additive_id;
        document.getElementById('edit-sub-name').value = sub.name;
        document.getElementById('edit-sub-status').value = sub.status;
        document.getElementById('modal-edit-sub').classList.remove('hidden');
    }
</script>

<!-- Alpine.js para interatividade do accordion -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
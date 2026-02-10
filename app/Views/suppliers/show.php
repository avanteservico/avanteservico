<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">
    <!-- Header -->
    <div class="mb-6">
        <a href="<?= BASE_URL ?>/suppliers" class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">&larr;
            Voltar para Lista</a>
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    <?= htmlspecialchars($supplier['name']) ?>
                </h1>
                <p class="text-gray-500">
                    <?= htmlspecialchars($supplier['phone'] ?? 'Sem telefone') ?>
                </p>
                <?php if (!empty($supplier['contact_name'])): ?>
                    <p class="text-sm text-gray-500 mt-1">
                        <span class="font-medium">Contato:</span> <?= htmlspecialchars($supplier['contact_name']) ?>
                        <?php if (!empty($supplier['contact_phone'])): ?>
                            <span class="mx-1">•</span> <?= htmlspecialchars($supplier['contact_phone']) ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
            </div>
            <a href="<?= BASE_URL ?>/suppliers/edit/<?= $supplier['id'] ?>"
                class="text-primary hover:text-blue-800 font-medium text-sm">Editar Informações</a>
        </div>
        <div class="mt-4 flex justify-between items-center">
            <?php if (!empty($supplier['observations'])): ?>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-sm text-gray-600 flex-1 mr-4">
                    <?= nl2br(htmlspecialchars($supplier['observations'])) ?>
                </div>
            <?php else: ?>
                <div class="flex-1"></div>
            <?php endif; ?>
            <button onclick="document.getElementById('modal-expense').classList.remove('hidden')"
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md transition-colors duration-200 flex items-center text-sm font-medium whitespace-nowrap h-fit">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Lançar Despesa
            </button>
        </div>
    </div>

    <!-- Financial Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">Total Pago a este Fornecedor
            </div>
            <div class="text-2xl font-bold text-green-600">R$
                <?= number_format($summary['total_paid'] ?? 0, 2, ',', '.') ?>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">Pendente a Pagar</div>
            <div class="text-2xl font-bold text-red-500">R$
                <?= number_format($summary['total_pending'] ?? 0, 2, ',', '.') ?>
            </div>
        </div>
    </div>

    <!-- Expenses List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-900">Histórico de Despesas</h3>
        </div>

        <?php if (empty($expenses)): ?>
            <div class="p-8 text-center text-gray-400 italic">
                Nenhuma despesa vinculada a este fornecedor.
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Obra
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Despesa/Material</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Valor</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($expenses as $expense): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= date('d/m/Y', strtotime($expense['purchase_date'])) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?= htmlspecialchars($expense['work_name'] ?? 'Geral') ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <?= htmlspecialchars($expense['name']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= htmlspecialchars($expense['expense_type_name'] ?? '-') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900">
                                    R$
                                    <?= number_format($expense['amount'], 2, ',', '.') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $expense['is_paid'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= $expense['is_paid'] ? 'Pago' : 'Pendente' ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Nova Despesa -->
<div id="modal-expense" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="<?= BASE_URL ?>/materials/create" method="POST">
                <input type="hidden" name="supplier_id" value="<?= $supplier['id'] ?>">
                <!-- Redirect hack: we can add a redirect_to field if controller supports it, 
                     otherwise we might need to rely on HTTP_REFERER or generic logic. 
                     For now, MaterialController redirects to /materials?work_id=... or /materials. 
                     We might want to improve this later. -->
                <input type="hidden" name="redirect_to" value="supplier_details">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Lançar Despesa
                        (<?= htmlspecialchars($supplier['name']) ?>)</h3>
                    <div class="mt-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descrição do Material/Serviço</label>
                            <input type="text" name="name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Valor (R$)</label>
                                <input type="text" name="amount" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50 mask-money"
                                    placeholder="0,00">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Data Compra</label>
                                <input type="date" name="purchase_date" required value="<?= date('Y-m-d') ?>"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
                            </div>
                        </div>

                        <!-- Work Selection is tricky since we don't have all works here.
                             We need to pass works to this view or fetch them via current user context.
                             For now, let's assume we can load them or use an async fetch/simple workaround.
                             Actually, SupplierController doesn't load works. 
                             We should probably fetch them. -->
                        <!-- Let's load the works dynamically or check if $works is available. 
                              It is NOT available in SupplierController::show(). 
                              I will need to update SupplierController::show() to pass $works. -->

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Obra (Opcional)</label>
                            <select name="work_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
                                <option value="">Selecione uma obra...</option>
                                <?php if (isset($works)):
                                    foreach ($works as $w): ?>
                                        <option value="<?= $w['id'] ?>"><?= htmlspecialchars($w['name']) ?></option>
                                    <?php endforeach; endif; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo de Despesa</label>
                            <select name="expense_type_id" id="expense_type_id" onchange="toggleNewExpenseType()"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50">
                                <?php if (isset($expenseTypes)):
                                    foreach ($expenseTypes as $type): ?>
                                        <option value="<?= $type['id'] ?>"><?= htmlspecialchars($type['name']) ?></option>
                                    <?php endforeach; endif; ?>
                                <option value="new">➕ Novo Tipo de Despesa</option>
                            </select>
                        </div>
                        <div id="new_expense_type_container" style="display: none;">
                            <label class="block text-sm font-medium text-gray-700">Nome do Novo Tipo</label>
                            <input type="text" name="new_expense_type" id="new_expense_type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50"
                                placeholder="Ex: Mão de Obra, Transporte">
                        </div>

                        <div class="flex items-center mt-4">
                            <input type="checkbox" name="is_paid" id="expense_is_paid"
                                class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                            <label for="expense_is_paid" class="ml-2 block text-sm text-gray-900">
                                Pago (Marcar se já foi quitado)
                            </label>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Salvar
                        Despesa</button>
                    <button type="button" onclick="document.getElementById('modal-expense').classList.add('hidden')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleNewExpenseType() {
        const select = document.getElementById('expense_type_id');
        const container = document.getElementById('new_expense_type_container');
        const input = document.getElementById('new_expense_type');

        if (select.value === 'new') {
            container.style.display = 'block';
            input.required = true;
        } else {
            container.style.display = 'none';
            input.required = false;
            input.value = '';
        }
    }
</script>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">

    <!-- Header -->
    <div class="mb-6">
        <?php if ($work): ?>
            <a href="<?= BASE_URL ?>/works/show/<?= $work['id'] ?>"
                class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">&larr; Voltar para Obra</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/financial" class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">&larr;
                Voltar para Financeiro</a>
        <?php endif; ?>
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Materiais e Despesas</h1>
                <p class="text-gray-500">
                    <?= $work ? htmlspecialchars($work['name']) : 'Todas as Obras' ?>
                </p>
            </div>
            <button onclick="openMaterialModal()"
                class="bg-primary hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow-md transition-colors duration-200 flex items-center text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nova Despesa
            </button>
        </div>
    </div>

    <!-- Resumo Financeiro -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">Total Pago</div>
            <div class="text-2xl font-bold text-red-600">- R$
                <?= number_format($summary['total_paid'] ?? 0, 2, ',', '.') ?>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">A Pagar (Pendente)</div>
            <div class="text-2xl font-bold text-red-400">- R$
                <?= number_format($summary['total_pending'] ?? 0, 2, ',', '.') ?>
            </div>
        </div>
    </div>

    <!-- Lista de Materiais -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <?php if (empty($materials)): ?>
            <div class="p-8 text-center text-gray-400 italic">
                Nenhuma despesa ou material cadastrado.
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descrição / Material</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fornecedor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Data Compra</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Valor</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($materials as $material): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars($material['name']) ?>
                                    </div>
                                    <?php if (!$work): ?>
                                        <div class="text-xs text-gray-400">
                                            <?= htmlspecialchars($material['work_name'] ?? 'Sem Obra') ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?= htmlspecialchars($material['supplier_name'] ?? 'Padrão') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?= htmlspecialchars($material['expense_type_name'] ?? 'Diversas') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    <?= date('d/m/Y', strtotime($material['purchase_date'])) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600 text-right">
                                    - R$
                                    <?= number_format($material['amount'], 2, ',', '.') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $material['is_paid'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= $material['is_paid'] ? 'Pago' : 'A Pagar' ?>
                                    </span>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end space-x-3">
                                    <button onclick='editMaterial(<?= json_encode($material) ?>)'
                                        class="text-primary hover:text-blue-900">Editar</button>
                                    <a href="<?= BASE_URL ?>/materials/delete/<?= $material['id'] ?><?= $work ? '?work_id=' . $work['id'] : '' ?>"
                                        onclick="return confirm('Excluir esta despesa?')"
                                        class="text-red-600 hover:text-red-900">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Nova/Editar Despesa -->
<div id="modal-material" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="form-material" action="<?= BASE_URL ?>/materials/create" method="POST">
                <input type="hidden" name="id" id="material_id">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-material-title">Nova Despesa /
                        Material
                    </h3>
                    <div class="mt-4 space-y-4">
                        <input type="hidden" name="work_id" value="<?= $work['id'] ?>">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descrição do Material</label>
                            <input type="text" name="name" id="material_name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                placeholder="Ex: Cimento, Areia, Tijolos">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fornecedor</label>
                            <select name="supplier_id" id="supplier_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                <?php foreach ($suppliers as $supplier): ?>
                                    <option value="<?= $supplier['id'] ?>"><?= htmlspecialchars($supplier['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="text-xs text-right mt-1"><a href="<?= BASE_URL ?>/suppliers/create"
                                    class="text-primary hover:underline" target="_blank">Cadastrar novo fornecedor</a>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo de Despesa</label>
                            <select name="expense_type_id" id="expense_type_id" required
                                onchange="toggleNewExpenseType()"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                <?php foreach ($expenseTypes as $type): ?>
                                    <option value="<?= $type['id'] ?>"><?= htmlspecialchars($type['name']) ?></option>
                                <?php endforeach; ?>
                                <option value="new">➕ Novo Tipo de Despesa</option>
                            </select>
                        </div>
                        <div id="new_expense_type_container" style="display: none;">
                            <label class="block text-sm font-medium text-gray-700">Nome do Novo Tipo</label>
                            <input type="text" name="new_expense_type" id="new_expense_type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                placeholder="Ex: Mão de Obra, Transporte">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Valor (R$)</label>
                            <input type="text" name="amount" id="material_amount" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 mask-money">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Data da Compra</label>
                            <input type="date" name="purchase_date" id="material_purchase_date" required
                                value="<?= date('Y-m-d') ?>"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        <div class="flex items-center mt-4">
                            <input type="checkbox" name="is_paid" id="is_paid_material"
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="is_paid_material" class="ml-2 block text-sm text-gray-900">
                                Já foi pago?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-blue-800 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Salvar</button>
                    <button type="button" onclick="closeMaterialModal()"
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

    function openMaterialModal() {
        document.getElementById('modal-material').classList.remove('hidden');
        document.getElementById('form-material').action = '<?= BASE_URL ?>/materials/create';
        document.getElementById('modal-material-title').innerText = 'Nova Despesa / Material';
        document.getElementById('material_id').value = '';
        document.getElementById('material_name').value = '';
        document.getElementById('material_amount').value = '';
        document.getElementById('supplier_id').value = '1';
        document.getElementById('expense_type_id').value = '1';
        document.getElementById('is_paid_material').checked = false;
        toggleNewExpenseType();
    }

    function closeMaterialModal() {
        document.getElementById('modal-material').classList.add('hidden');
    }

    function editMaterial(material) {
        openMaterialModal();
        document.getElementById('form-material').action = '<?= BASE_URL ?>/materials/update';
        document.getElementById('modal-material-title').innerText = 'Editar Despesa';

        document.getElementById('material_id').value = material.id;
        document.getElementById('material_name').value = material.name;
        document.getElementById('material_purchase_date').value = material.purchase_date;
        document.getElementById('supplier_id').value = material.supplier_id || '1';
        document.getElementById('expense_type_id').value = material.expense_type_id || '1';
        document.getElementById('is_paid_material').checked = (material.is_paid == 1);
        toggleNewExpenseType();

        const amount = parseFloat(material.amount).toLocaleString('pt-BR', { minimumFractionDigits: 2 });
        document.getElementById('material_amount').value = amount;
    }

    // Auto-open modal if action=new is present and pre-fill supplier if supplier_id is present
    window.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('action') === 'new') {
            openMaterialModal();

            const supplierId = urlParams.get('supplier_id');
            if (supplierId) {
                const supplierSelect = document.getElementById('supplier_id');
                if (supplierSelect) {
                    supplierSelect.value = supplierId;
                }
            }
        }
    });
</script>
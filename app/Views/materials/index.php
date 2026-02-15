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

    <!-- Lista de Materiais Agrupada por Fornecedor -->
    <div class="space-y-6">
        <?php if (empty($suppliersGrouped)): ?>
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center text-gray-400 italic">
                Nenhuma despesa ou material cadastrado.
            </div>
        <?php else: ?>
            <div class="flex overflow-x-auto pb-4 gap-6 snap-x scrollbar-hide sm:scrollbar-default">
                <?php foreach ($suppliersGrouped as $sId => $group): ?>
                    <div
                        class="min-w-[300px] md:min-w-[350px] bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-md transition-shadow duration-200 snap-start">
                        <!-- Card Header -->
                        <div class="p-5 border-b border-gray-50 bg-gray-50/30">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg font-bold text-gray-900 line-clamp-1"
                                    title="<?= htmlspecialchars($group['name']) ?>">
                                    <?= htmlspecialchars($group['name']) ?>
                                </h3>
                                <div class="bg-primary/10 text-primary p-1.5 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500">Pago:</span>
                                    <span class="font-bold text-green-600">
                                        R$
                                        <?= number_format($group['total_paid'], 2, ',', '.') ?>
                                    </span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500">A Pagar:</span>
                                    <span class="font-bold text-red-500">
                                        R$
                                        <?= number_format($group['total_pending'], 2, ',', '.') ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Actions & Toggle -->
                        <div class="px-5 py-3 bg-white flex justify-between items-center">
                            <button onclick="toggleSupplierItems(<?= $sId ?>)"
                                class="text-primary hover:text-blue-800 text-sm font-semibold flex items-center transition-colors">
                                <span id="toggle-text-<?= $sId ?>">Ver Detalhes (
                                    <?= count($group['items']) ?>)
                                </span>
                                <svg id="toggle-icon-<?= $sId ?>" xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 ml-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <a href="<?= BASE_URL ?>/materials?work_id=<?= $work['id'] ?>&action=new&supplier_id=<?= $sId ?>"
                                class="text-gray-400 hover:text-primary p-1 bg-gray-50 rounded-full transition-colors"
                                title="Nova despesa para este fornecedor">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </a>
                        </div>

                        <!-- Items List (Hidden by default) -->
                        <div id="supplier-items-<?= $sId ?>" class="hidden border-t border-gray-100 bg-gray-50/50">
                            <div class="px-5 py-4 space-y-3">
                                <?php foreach ($group['items'] as $material): ?>
                                    <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm relative group">
                                        <div class="flex justify-between items-start mb-1">
                                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                <?= date('d/m/Y', strtotime($material['purchase_date'])) ?>
                                            </span>
                                            <span
                                                class="px-2 py-0.5 text-[10px] font-bold rounded-full <?= $material['is_paid'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                                                <?= $material['is_paid'] ? 'PAGO' : 'PENDENTE' ?>
                                            </span>
                                        </div>
                                        <div class="text-sm font-bold text-gray-900 pr-8">
                                            <?= htmlspecialchars($material['name']) ?>
                                        </div>
                                        <div class="flex justify-between items-end mt-2">
                                            <div class="text-[10px] text-gray-400">
                                                Tipo:
                                                <?= htmlspecialchars($material['expense_type_name'] ?? 'Diversas') ?>
                                            </div>
                                            <div
                                                class="text-sm font-black <?= $material['is_paid'] ? 'text-green-600' : 'text-red-500' ?>">
                                                R$
                                                <?= number_format($material['amount'], 2, ',', '.') ?>
                                            </div>
                                        </div>

                                        <!-- Mini Actions -->
                                        <div
                                            class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity flex space-x-1">
                                            <button onclick='editMaterial(<?= json_encode($material) ?>)'
                                                class="p-1 text-primary hover:bg-primary/10 rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            <a href="<?= BASE_URL ?>/materials/delete/<?= $material['id'] ?><?= $work ? '?work_id=' . $work['id'] : '' ?>"
                                                onclick="return confirm('Excluir esta despesa?')"
                                                class="p-1 text-red-500 hover:bg-red-50 rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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
                                    <option value="<?= $supplier['id'] ?>">
                                        <?= htmlspecialchars($supplier['name']) ?>
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
                                    <option value="<?= $type['id'] ?>">
                                        <?= htmlspecialchars($type['name']) ?>
                                    </option>
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
    function toggleSupplierItems(sId) {
        const itemsDiv = document.getElementById(`supplier-items-${sId}`);
        const toggleText = document.getElementById(`toggle-text-${sId}`);
        const toggleIcon = document.getElementById(`toggle-icon-${sId}`);
        const isHidden = itemsDiv.classList.contains('hidden');

        if (isHidden) {
            itemsDiv.classList.remove('hidden');
            toggleText.innerText = 'Recolher Detalhes';
            toggleIcon.style.transform = 'rotate(180deg)';
        } else {
            itemsDiv.classList.add('hidden');
            toggleText.innerText = `Ver Detalhes (${itemsDiv.querySelectorAll('.bg-white').length})`;
            toggleIcon.style.transform = 'rotate(0deg)';
        }
    }

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
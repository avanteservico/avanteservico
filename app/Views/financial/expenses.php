<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">

    <!-- Header -->
    <div class="mb-6">
        <a href="<?= BASE_URL ?>/dashboard" class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">&larr;
            Voltar para Dashboard</a>
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Todas as Despesas</h1>
                <p class="text-gray-500">Despesas de todas as obras</p>
            </div>
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

    <!-- Lista de Despesas Agrupada por Fornecedor -->
    <div class="space-y-6">
        <?php if (empty($suppliersGrouped)): ?>
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center text-gray-400 italic">
                Nenhuma despesa ou material cadastrado.
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($suppliersGrouped as $sId => $group): ?>
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-md transition-shadow duration-200">
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
                        </div>

                        <!-- Items List (Hidden by default) -->
                        <div id="supplier-items-<?= $sId ?>" class="hidden border-t border-gray-100 bg-gray-50/50">
                            <div class="px-5 py-4 space-y-3">
                                <?php foreach ($group['items'] as $expense): ?>
                                    <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm relative group">
                                        <div class="flex justify-between items-start mb-1">
                                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                <?= date('d/m/Y', strtotime($expense['purchase_date'])) ?>
                                            </span>
                                            <span
                                                class="px-2 py-0.5 text-[10px] font-bold rounded-full <?= $expense['is_paid'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                                                <?= $expense['is_paid'] ? 'PAGO' : 'PENDENTE' ?>
                                            </span>
                                        </div>
                                        <div class="text-sm font-bold text-gray-900 line-clamp-1">
                                            <?= htmlspecialchars($expense['name']) ?>
                                        </div>
                                        <div class="text-[10px] text-primary mt-1 font-medium">
                                            Obra:
                                            <?= htmlspecialchars($expense['work_name'] ?? 'Sem Obra') ?>
                                        </div>
                                        <div class="flex justify-between items-end mt-2">
                                            <div class="text-[10px] text-gray-400">
                                                Tipo:
                                                <?= htmlspecialchars($expense['expense_type_name'] ?? 'Diversas') ?>
                                            </div>
                                            <div
                                                class="text-sm font-black <?= $expense['is_paid'] ? 'text-green-600' : 'text-red-500' ?>">
                                                R$
                                                <?= number_format($expense['amount'], 2, ',', '.') ?>
                                            </div>
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
</script>
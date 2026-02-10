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

    <!-- Lista de Despesas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <?php if (empty($expenses)): ?>
            <div class="p-8 text-center text-gray-400 italic">
                Nenhuma despesa cadastrada.
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Obra</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descrição</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Data</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Valor</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($expenses as $expense): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars($expense['work_name'] ?? 'Sem Obra') ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        <?= htmlspecialchars($expense['name']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?= htmlspecialchars($expense['expense_type_name'] ?? 'Diversas') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    <?= date('d/m/Y', strtotime($expense['purchase_date'])) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600 text-right">
                                    - R$
                                    <?= number_format($expense['amount'], 2, ',', '.') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $expense['is_paid'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= $expense['is_paid'] ? 'Pago' : 'A Pagar' ?>
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
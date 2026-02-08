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
                <h1 class="text-2xl font-bold text-gray-900">Receitas</h1>
                <p class="text-gray-500">
                    <?= $work ? htmlspecialchars($work['name']) : 'Todas as Obras' ?>
                </p>
            </div>
            <button onclick="openModal('modal-revenue')"
                class="bg-primary hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow-md transition-colors duration-200 flex items-center text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nova Receita
            </button>
        </div>
    </div>

    <!-- Resumo Financeiro -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">Total Recebido</div>
            <div class="text-2xl font-bold text-blue-600">+ R$
                <?= number_format($summary['total_received'] ?? 0, 2, ',', '.') ?>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">A Receber</div>
            <div class="text-2xl font-bold text-blue-400">+ R$
                <?= number_format($summary['total_to_receive'] ?? 0, 2, ',', '.') ?>
            </div>
        </div>
    </div>

    <!-- Lista de Receitas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <?php if (empty($revenues)): ?>
            <div class="p-8 text-center text-gray-400 italic">
                Nenhuma receita cadastrada.
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descrição</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Data Recebimento</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Valor</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($revenues as $revenue): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 font-medium text-gray-900">
                                        <?= htmlspecialchars($revenue['description']) ?>
                                    </div>
                                    <?php if (!$work): ?>
                                        <div class="text-xs text-gray-400">
                                            <?= htmlspecialchars($revenue['work_name'] ?? 'Sem Obra') ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    <?= date('d/m/Y', strtotime($revenue['received_date'])) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600 text-right">
                                    + R$
                                    <?= number_format($revenue['amount'], 2, ',', '.') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $revenue['status'] == 'received' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                        <?= $revenue['status'] == 'received' ? 'Recebido' : 'A Receber' ?>
                                    </span>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end space-x-3">
                                    <button onclick='editRevenue(<?= json_encode($revenue) ?>)'
                                        class="text-primary hover:text-blue-900">Editar</button>
                                    <a href="<?= BASE_URL ?>/revenues/delete/<?= $revenue['id'] ?><?= $work ? '?work_id=' . $work['id'] : '' ?>"
                                        onclick="return confirm('Excluir esta receita?')"
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

<!-- Modal Nova/Editar Receita -->
<div id="modal-revenue" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="form-revenue" action="<?= BASE_URL ?>/revenues/create" method="POST">
                <input type="hidden" name="id" id="revenue_id">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Lançar Receita</h3>
                    <div class="mt-4 space-y-4">
                        <input type="hidden" name="work_id" value="<?= $work['id'] ?>">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descrição</label>
                            <input type="text" name="description" id="revenue_description" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                placeholder="Ex: Adiantamento 1ª Parcela">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Valor (R$)</label>
                            <input type="text" name="amount" id="revenue_amount" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 mask-money">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Data Real/Prevista</label>
                            <input type="date" name="received_date" id="revenue_received_date" required
                                value="<?= date('Y-m-d') ?>"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        <div class="flex items-center mt-4">
                            <input type="checkbox" name="is_received" id="is_received"
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="is_received" class="ml-2 block text-sm text-gray-900">
                                Já foi recebido em conta?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-blue-800 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Salvar</button>
                    <button type="button" onclick="closeModal('modal-revenue')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        if (id === 'modal-revenue') {
            document.getElementById('form-revenue').action = '<?= BASE_URL ?>/revenues/create';
            document.getElementById('modal-title').innerText = 'Nova Receita';
            document.getElementById('revenue_id').value = '';
            document.getElementById('revenue_description').value = '';
            document.getElementById('revenue_amount').value = '';
            document.getElementById('is_received').checked = false;
        }
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function editRevenue(revenue) {
        openModal('modal-revenue');
        document.getElementById('form-revenue').action = '<?= BASE_URL ?>/revenues/update';
        document.getElementById('modal-title').innerText = 'Editar Receita';

        document.getElementById('revenue_id').value = revenue.id;
        document.getElementById('revenue_description').value = revenue.description;
        document.getElementById('revenue_received_date').value = revenue.received_date;
        document.getElementById('is_received').checked = (revenue.status === 'received');

        const amount = parseFloat(revenue.amount).toLocaleString('pt-BR', { minimumFractionDigits: 2 });
        document.getElementById('revenue_amount').value = amount;
    }
</script>
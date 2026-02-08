<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">

    <!-- Header -->
    <div class="mb-6">
        <a href="<?= BASE_URL ?>/people" class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">&larr;
            Voltar para Lista</a>
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row justify-between items-start md:items-center">
            <div class="flex items-center space-x-4 mb-4 md:mb-0">
                <div
                    class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center text-primary font-bold text-2xl">
                    <?= strtoupper(substr($person['name'], 0, 1)) ?>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        <?= htmlspecialchars($person['name']) ?>
                    </h1>
                    <p class="text-gray-500">
                        <?= htmlspecialchars($person['role']) ?> •
                        <?= ucfirst($person['service_type']) ?>
                    </p>
                    <?php if ($person['phone']): ?>
                        <p class="text-sm text-gray-400 mt-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <?= htmlspecialchars($person['phone']) ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex space-x-3">
                <button onclick="document.getElementById('modal-payment').classList.remove('hidden')"
                    class="bg-primary hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow-md transition-colors duration-200 flex items-center text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Lançar Pagamento
                </button>
            </div>
        </div>
    </div>

    <!-- Resumo Financeiro -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">Total Recebido (Pago)</div>
            <div class="text-2xl font-bold text-green-600">R$
                <?= number_format($summary['total_paid'] ?? 0, 2, ',', '.') ?>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">A Receber (Pendente)</div>
            <div class="text-2xl font-bold text-red-500">R$
                <?= number_format($summary['total_pending'] ?? 0, 2, ',', '.') ?>
            </div>
        </div>
    </div>

    <!-- Histórico de Pagamentos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900">Histórico de Pagamentos</h3>
        </div>
        <?php if (empty($payments)): ?>
            <div class="p-8 text-center text-gray-400 italic">
                Nenhum pagamento registrado.
            </div>
        <?php else: ?>
            <ul class="divide-y divide-gray-100">
                <?php foreach ($payments as $payment): ?>
                    <li class="p-6 hover:bg-gray-50 flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="mb-2 md:mb-0">
                            <p class="font-semibold text-gray-900">
                                <?= htmlspecialchars($payment['description']) ?>
                            </p>
                            <p class="text-sm text-gray-500">
                                <?= $payment['work_name'] ? 'Obra: ' . htmlspecialchars($payment['work_name']) : 'Sem obra vinculada' ?>
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                <?= date('d/m/Y', strtotime($payment['payment_date'])) ?>
                            </p>
                        </div>
                        <div class="flex items-center md:items-center space-x-6">
                            <div class="text-right">
                                <p class="font-bold text-lg <?= $payment['is_paid'] ? 'text-green-600' : 'text-red-500' ?>">
                                    R$
                                    <?= number_format($payment['amount'], 2, ',', '.') ?>
                                </p>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $payment['is_paid'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= $payment['is_paid'] ? 'Pago' : 'A Pagar' ?>
                                </span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick='openEditPaymentModal(<?= json_encode($payment) ?>)'
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <a href="<?= BASE_URL ?>/people/deletePayment/<?= $payment['id'] ?>?person_id=<?= $person['id'] ?>"
                                    onclick="return confirm('Tem certeza que deseja excluir este pagamento?')"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Excluir">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Pagamento -->
<div id="modal-payment" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="<?= BASE_URL ?>/people/createPayment" method="POST">
                <input type="hidden" name="person_id" value="<?= $person['id'] ?>">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Novo Pagamento</h3>
                    <div class="mt-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Valor (R$)</label>
                            <input type="text" name="amount" id="amount" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 mask-money"
                                placeholder="0,00">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Data</label>
                            <input type="date" name="payment_date" required value="<?= date('Y-m-d') ?>"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descrição</label>
                            <input type="text" name="description" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                placeholder="Ex: Pagamento semanal">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Vincular a Obra (Opcional)</label>
                            <select name="work_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                <option value="">Sem vínculo</option>
                                <?php foreach ($works as $w): ?>
                                    <option value="<?= $w['id'] ?>">
                                        <?= htmlspecialchars($w['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="flex items-center mt-4">
                            <input type="checkbox" name="is_paid" id="is_paid"
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="is_paid" class="ml-2 block text-sm text-gray-900">
                                Pagamento já efetuado (Baixa imediata)
                            </label>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-blue-800 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Salvar</button>
                    <button type="button" onclick="document.getElementById('modal-payment').classList.add('hidden')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Pagamento -->
<div id="modal-edit-payment" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="<?= BASE_URL ?>/people/updatePayment" method="POST">
                <input type="hidden" name="id" id="edit-payment-id">
                <input type="hidden" name="person_id" value="<?= $person['id'] ?>">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Editar Pagamento</h3>
                        <button type="button"
                            onclick="document.getElementById('modal-edit-payment').classList.add('hidden')"
                            class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Valor (R$)</label>
                            <input type="text" name="amount" id="edit-payment-amount" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 mask-money"
                                placeholder="0,00">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Data</label>
                            <input type="date" name="payment_date" id="edit-payment-date" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descrição</label>
                            <input type="text" name="description" id="edit-payment-description" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                placeholder="Ex: Pagamento semanal">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Vincular a Obra (Opcional)</label>
                            <select name="work_id" id="edit-payment-work-id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                <option value="">Sem vínculo</option>
                                <?php foreach ($works as $w): ?>
                                    <option value="<?= $w['id'] ?>">
                                        <?= htmlspecialchars($w['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="flex items-center mt-4">
                            <input type="checkbox" name="is_paid" id="edit-payment-is-paid"
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="edit-payment-is-paid" class="ml-2 block text-sm text-gray-900">
                                Pagamento já efetuado (Baixa imediata)
                            </label>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-blue-800 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Salvar
                        Alterações</button>
                    <button type="button"
                        onclick="document.getElementById('modal-edit-payment').classList.add('hidden')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditPaymentModal(payment) {
        document.getElementById('edit-payment-id').value = payment.id;
        document.getElementById('edit-payment-amount').value = parseFloat(payment.amount).toLocaleString('pt-BR', { minimumFractionDigits: 2 });
        document.getElementById('edit-payment-date').value = payment.payment_date;
        document.getElementById('edit-payment-description').value = payment.description;
        document.getElementById('edit-payment-work-id').value = payment.work_id || '';
        document.getElementById('edit-payment-is-paid').checked = (payment.is_paid == 1);

        document.getElementById('modal-edit-payment').classList.remove('hidden');
    }
</script>
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
                    value="<?= htmlspecialchars($additive['name']) ?>">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700 mb-1">Valor a Pagar (R$) *</label>
                    <input type="text" name="value" id="value" required
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 mask-money"
                        placeholder="0,00" value="<?= number_format($additive['value'], 2, ',', '.') ?>"
                        oninput="calculateDue()">
                </div>
                <div>
                    <label for="executed_percentage" class="block text-sm font-medium text-gray-700 mb-1">%
                        Executado</label>
                    <input type="text" name="executed_percentage" id="executed_percentage"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 mask-percent"
                        placeholder="0,00" value="<?= number_format($additive['executed_percentage'], 2, ',', '.') ?>"
                        oninput="calculateDue()">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Valor Devido (R$)</label>
                    <input type="text" id="valor_devido_display" readonly
                        class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-500 cursor-not-allowed font-semibold"
                        value="<?= number_format($additive['valor_devido'], 2, ',', '.') ?>">
                    <p class="text-xs text-gray-400 mt-1">Calculado: % Executado × Valor a Pagar</p>
                </div>
                <div>
                    <label for="paid_value" class="block text-sm font-medium text-gray-700 mb-1">Valor Recebido
                        (R$)</label>
                    <input type="text" name="paid_value" id="paid_value"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 mask-money"
                        placeholder="0,00" value="<?= number_format($additive['paid_value'], 2, ',', '.') ?>">
                </div>
            </div>

            <!-- Situação (calculada pelo % Executado) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Situação</label>
                <div id="status_badge" class="mt-1">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $additive['status'] == 'finalizado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                        <?= ucfirst($additive['status']) ?>
                    </span>
                </div>
                <p class="text-xs text-gray-400 mt-1">Definida automaticamente: 100% executado = Finalizado</p>
            </div>

            <!-- Subetapas existentes (visualização) -->
            <?php if (!empty($subAdditives)): ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subetapas cadastradas</label>
                    <ul class="space-y-1">
                        <?php foreach ($subAdditives as $sub): ?>
                            <li class="flex items-center justify-between text-sm text-gray-600 bg-gray-50 rounded px-3 py-2">
                                <span><?= htmlspecialchars($sub['name']) ?></span>
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
                <!-- Botão Excluir -->
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

<script>
    let currentValue = <?= $additive['value'] ?>;

    function calculateDue() {
        const valueStr = document.getElementById('value').value;
        const percentStr = document.getElementById('executed_percentage').value;

        const value = parseFloat((valueStr || '0').replace(/\./g, '').replace(',', '.')) || 0;
        const percent = parseFloat((percentStr || '0').replace(/\./g, '').replace(',', '.')) || 0;

        const due = (value * percent) / 100;
        document.getElementById('valor_devido_display').value = due.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        // Atualizar situação visualmente
        const statusBadge = document.getElementById('status_badge');
        if (percent >= 100) {
            statusBadge.innerHTML = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Finalizado</span>';
        } else {
            statusBadge.innerHTML = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Pendente</span>';
        }
    }

    document.getElementById('value').addEventListener('change', calculateDue);
    document.getElementById('executed_percentage').addEventListener('change', calculateDue);
</script>
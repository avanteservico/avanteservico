<div class="max-w-2xl mx-auto px-4 py-8 mb-20">
    <div class="mb-8">
        <a href="<?= BASE_URL ?>/services?work_id=<?= $work['id'] ?>"
            class="flex items-center text-gray-500 hover:text-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Voltar para Serviços
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-4">Editar Serviço</h1>
        <p class="text-sm text-gray-500">Obra: <strong>
                <?= htmlspecialchars($work['name']) ?>
            </strong></p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="<?= BASE_URL ?>/services/update" method="POST" class="p-6 space-y-6">
            <input type="hidden" name="id" value="<?= $service['id'] ?>">
            <input type="hidden" name="work_id" value="<?= $work['id'] ?>">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome do Serviço *</label>
                <input type="text" name="name" id="name" required
                    class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    placeholder="Ex: Fundação, Alvenaria, Elétrica..."
                    value="<?= htmlspecialchars($service['name']) ?>">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="percentage_work" class="block text-sm font-medium text-gray-700 mb-1">Percentual da Obra
                        (%) *</label>
                    <input type="text" name="percentage_work" id="percentage_work" required
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 mask-percent"
                        placeholder="0,00" value="<?= number_format($service['percentage_work'], 2, ',', '.') ?>"
                        oninput="calculateValue()">
                </div>
                <div>
                    <label for="value_display" class="block text-sm font-medium text-gray-700 mb-1">Valor Calculado
                        (R$)</label>
                    <input type="text" id="value_display" readonly
                        class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-500 cursor-not-allowed font-semibold"
                        value="<?= number_format($service['value'], 2, ',', '.') ?>">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="executed_percentage" class="block text-sm font-medium text-gray-700 mb-1">% Executado
                        *</label>
                    <input type="text" name="executed_percentage" id="executed_percentage" required
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 mask-percent <?= !empty($subServices) ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '' ?>"
                        placeholder="0,00" value="<?= number_format($service['executed_percentage'], 2, ',', '.') ?>"
                        oninput="calculateDueValue()" <?= !empty($subServices) ? 'readonly' : '' ?>>
                    <?php if (!empty($subServices)): ?>
                        <p class="text-xs text-blue-600 mt-1 italic">Calculado automaticamente através das etapas.</p>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="valor_devido_display" class="block text-sm font-medium text-gray-700 mb-1">Valor Devido
                        (R$)</label>
                    <input type="text" id="valor_devido_display" readonly
                        class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-500 cursor-not-allowed font-semibold"
                        value="<?= number_format($service['valor_devido'], 2, ',', '.') ?>">
                    <p class="text-xs text-gray-500 mt-1">% Executado x Valor Calculado</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="paid_value" class="block text-sm font-medium text-gray-700 mb-1">Valor Recebido
                        (R$)</label>
                    <input type="text" name="paid_value" id="paid_value" required
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 mask-money"
                        placeholder="0,00" value="<?= number_format($service['paid_value'], 2, ',', '.') ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Atual</label>
                    <div id="status_badge" class="mt-2">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $service['status'] == 'finalizado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                            <?= ucfirst($service['status']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end space-x-4">
                <a href="<?= BASE_URL ?>/services?work_id=<?= $work['id'] ?>"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Cancelar</a>
                <button type="submit"
                    class="px-6 py-2 bg-primary hover:bg-blue-800 text-white rounded-lg text-sm font-medium shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Atualizar Serviço
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const totalWorkValue = <?= $work['total_value'] ?>;

    let currentCalculatedValue = <?= $service['value'] ?>;

    function calculateValue() {
        let percentageStr = document.getElementById('percentage_work').value;
        if (percentageStr) {
            let percentage = parseFloat(percentageStr.replace(/\./g, '').replace(',', '.'));
            if (isNaN(percentage)) percentage = 0;

            currentCalculatedValue = (totalWorkValue * percentage) / 100;
            const valueDisplay = document.getElementById('value_display');
            valueDisplay.value = currentCalculatedValue.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            // Recalcular valor devido também
            calculateDueValue();
        } else {
            document.getElementById('value_display').value = '';
        }
    }

    function calculateDueValue() {
        let execPercentageStr = document.getElementById('executed_percentage').value;
        if (execPercentageStr) {
            let execPercentage = parseFloat(execPercentageStr.replace(/\./g, '').replace(',', '.'));
            if (isNaN(execPercentage)) execPercentage = 0;

            const dueValue = (currentCalculatedValue * execPercentage) / 100;
            document.getElementById('valor_devido_display').value = dueValue.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            // Atualizar badge de status visual
            const statusBadge = document.getElementById('status_badge');
            if (execPercentage >= 100) {
                statusBadge.innerHTML = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Finalizado</span>';
            } else {
                statusBadge.innerHTML = '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Pendente</span>';
            }
        }
    }

    // Ouvir também o evento de mudança personalizado do footer.php
    document.getElementById('percentage_work').addEventListener('change', calculateValue);
    document.getElementById('executed_percentage').addEventListener('change', calculateDueValue);
</script>
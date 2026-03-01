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
        <h1 class="text-2xl font-bold text-gray-900 mt-4">Novo Aditivo</h1>
        <p class="text-sm text-gray-500">Adicionar aditivo à obra: <strong>
                <?= htmlspecialchars($work['name']) ?>
            </strong></p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="<?= BASE_URL ?>/additives/create" method="POST" class="p-6 space-y-6">
            <input type="hidden" name="work_id" value="<?= $work['id'] ?>">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome do Aditivo *</label>
                <input type="text" name="name" id="name" required
                    class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50"
                    placeholder="Ex: Acréscimo de Obra Civil, Revisão de Projeto...">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700 mb-1">Valor a Pagar (R$) *</label>
                    <input type="text" name="value" id="value" required
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 mask-money"
                        placeholder="0,00" oninput="calculateDue()">
                </div>
                <div>
                    <label for="executed_percentage" class="block text-sm font-medium text-gray-700 mb-1">%
                        Executado</label>
                    <input type="text" name="executed_percentage" id="executed_percentage"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 mask-percent"
                        placeholder="0,00" value="0,00" oninput="calculateDue()">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Valor Devido (R$)</label>
                    <input type="text" id="valor_devido_display" readonly
                        class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-500 cursor-not-allowed font-semibold"
                        placeholder="0,00">
                    <p class="text-xs text-gray-400 mt-1">Calculado: % Executado × Valor a Pagar</p>
                </div>
                <div>
                    <label for="paid_value" class="block text-sm font-medium text-gray-700 mb-1">Valor Recebido
                        (R$)</label>
                    <input type="text" name="paid_value" id="paid_value"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 mask-money"
                        placeholder="0,00" value="0,00">
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end space-x-4">
                <a href="<?= BASE_URL ?>/additives?work_id=<?= $work['id'] ?>"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">Cancelar</a>
                <button type="submit"
                    class="px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg text-sm font-medium shadow-md focus:outline-none">
                    Salvar Aditivo
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function calculateDue() {
        const valueStr = document.getElementById('value').value;
        const percentStr = document.getElementById('executed_percentage').value;

        const value = parseFloat((valueStr || '0').replace(/\./g, '').replace(',', '.')) || 0;
        const percent = parseFloat((percentStr || '0').replace(/\./g, '').replace(',', '.')) || 0;

        const due = (value * percent) / 100;
        document.getElementById('valor_devido_display').value = due.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    document.getElementById('value').addEventListener('change', calculateDue);
    document.getElementById('executed_percentage').addEventListener('change', calculateDue);
</script>
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
        <h1 class="text-2xl font-bold text-gray-900 mt-4">Novo Serviço</h1>
        <p class="text-sm text-gray-500">Adicionar serviço à obra: <strong>
                <?= htmlspecialchars($work['name']) ?>
            </strong></p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="<?= BASE_URL ?>/services/create" method="POST" class="p-6 space-y-6">
            <input type="hidden" name="work_id" value="<?= $work['id'] ?>">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome do Serviço *</label>
                <input type="text" name="name" id="name" required
                    class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    placeholder="Ex: Fundação, Alvenaria, Elétrica...">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="percentage_work" class="block text-sm font-medium text-gray-700 mb-1">Percentual da Obra
                        (%) *</label>
                    <input type="text" name="percentage_work" id="percentage_work" required
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 mask-percent"
                        placeholder="0,00" oninput="calculateValue()">
                    <p class="text-xs text-gray-500 mt-1">Este percentual definirá o valor do serviço.</p>
                </div>
                <div>
                    <label for="value_display" class="block text-sm font-medium text-gray-700 mb-1">Valor Calculado
                        (R$)</label>
                    <input type="text" id="value_display" readonly
                        class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-500 cursor-not-allowed font-semibold"
                        placeholder="0,00">
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end space-x-4">
                <a href="<?= BASE_URL ?>/services?work_id=<?= $work['id'] ?>"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Cancelar</a>
                <button type="submit"
                    class="px-6 py-2 bg-primary hover:bg-blue-800 text-white rounded-lg text-sm font-medium shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Salvar Serviço
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const totalWorkValue = <?= $work['total_value'] ?>;

    function calculateValue() {
        // Pega o valor formatado (ex: 10,50)
        let percentageStr = document.getElementById('percentage_work').value;

        if (percentageStr) {
            // Converte para float (Ex: "10,50" -> 10.50)
            let percentage = parseFloat(percentageStr.replace(/\./g, '').replace(',', '.'));

            if (isNaN(percentage)) percentage = 0;

            const value = (totalWorkValue * percentage) / 100;

            const valueDisplay = document.getElementById('value_display');
            valueDisplay.value = value.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        } else {
            document.getElementById('value_display').value = '';
        }
    }

    // Ouvir também o evento de mudança personalizado do footer.php
    document.getElementById('percentage_work').addEventListener('change', calculateValue);
</script>
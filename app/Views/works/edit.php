<div class="max-w-2xl mx-auto px-4 py-8 mb-20">
    <div class="mb-8">
        <a href="<?= BASE_URL ?>/works" class="flex items-center text-gray-500 hover:text-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Voltar para lista
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-4">Editar Obra</h1>
        <p class="text-sm text-gray-500">Atualize os dados do projeto.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="<?= BASE_URL ?>/works/update" method="POST" class="p-6 space-y-6">
            <input type="hidden" name="id" value="<?= $work['id'] ?>">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome da Obra *</label>
                <input type="text" name="name" id="name" required
                    class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    placeholder="Ex: Construção Residencial Silva" value="<?= htmlspecialchars($work['name']) ?>">
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Endereço</label>
                <textarea name="address" id="address" rows="3"
                    class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    placeholder="Rua, Número, Bairro, Cidade"><?= htmlspecialchars($work['address']) ?></textarea>
            </div>

            <div>
                <label for="reference_point" class="block text-sm font-medium text-gray-700 mb-1">Ponto de
                    Referência</label>
                <input type="text" name="reference_point" id="reference_point"
                    class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    placeholder="Ex: Próximo ao mercado" value="<?= htmlspecialchars($work['reference_point']) ?>">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="total_value" class="block text-sm font-medium text-gray-700 mb-1">Valor Total (R$)
                        *</label>
                    <input type="text" name="total_value" id="total_value" required
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 mask-money"
                        placeholder="0,00" value="<?= number_format($work['total_value'], 2, ',', '.') ?>">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status"
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <option value="active" <?= $work['status'] == 'active' ? 'selected' : '' ?>>Ativa</option>
                        <option value="completed" <?= $work['status'] == 'completed' ? 'selected' : '' ?>>Concluída
                        </option>
                        <option value="paused" <?= $work['status'] == 'paused' ? 'selected' : '' ?>>Pausada</option>
                        <option value="canceled" <?= $work['status'] == 'canceled' ? 'selected' : '' ?>>Cancelada</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Data Início *</label>
                    <input type="date" name="start_date" id="start_date" required
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        value="<?= $work['start_date'] ?>">
                </div>
                <div>
                    <label for="end_date_prediction" class="block text-sm font-medium text-gray-700 mb-1">Previsão de
                        Término</label>
                    <input type="date" name="end_date_prediction" id="end_date_prediction"
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        value="<?= $work['end_date_prediction'] ?>">
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end space-x-4">
                <a href="<?= BASE_URL ?>/works"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Cancelar</a>
                <button type="submit"
                    class="px-6 py-2 bg-primary hover:bg-blue-800 text-white rounded-lg text-sm font-medium shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Salvar Alterações
                </button>
            </div>

        </form>
    </div>
</div>
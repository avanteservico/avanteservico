<div class="max-w-2xl mx-auto px-4 py-8 mb-20">
    <div class="mb-8">
        <a href="<?= BASE_URL ?>/people" class="flex items-center text-gray-500 hover:text-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Voltar para Lista
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-4">Cadastrar Pessoa</h1>
        <p class="text-sm text-gray-500">Adicione um novo prestador de serviço ou funcionário.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="<?= BASE_URL ?>/people/create" method="POST" class="p-6 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo *</label>
                    <input type="text" name="name" id="name" required
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>
                <div>
                    <label for="nickname" class="block text-sm font-medium text-gray-700 mb-1">Apelido</label>
                    <input type="text" name="nickname" id="nickname"
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefone / WhatsApp</label>
                <input type="text" name="phone" id="phone"
                    class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    placeholder="(99) 99999-9999">
            </div>

            <div x-data="{ role: '' }">
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Função</label>
                <select name="role" id="role" x-model="role"
                    class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    <option value="">Selecione...</option>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= htmlspecialchars($r) ?>">
                            <?= htmlspecialchars($r) ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="new">+ Nova Função</option>
                </select>

                <div x-show="role === 'new'" class="mt-3" style="display: none;">
                    <label for="new_role" class="block text-sm font-medium text-gray-700 mb-1">Nome da Nova
                        Função</label>
                    <input type="text" name="new_role" id="new_role"
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        placeholder="Ex: Pedreiro, Eletricista">
                </div>
            </div>

            <div>
                <label for="service_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Prestação</label>
                <select name="service_type" id="service_type"
                    class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    <option value="empreitada">Empreitada</option>
                    <option value="diaria">Diária</option>
                    <option value="mensal">Mensal</option>
                </select>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descrição /
                    Observações</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"></textarea>
            </div>

            <div class="pt-4 flex items-center justify-end space-x-4">
                <a href="<?= BASE_URL ?>/people"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Cancelar</a>
                <button type="submit"
                    class="px-6 py-2 bg-primary hover:bg-blue-800 text-white rounded-lg text-sm font-medium shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Salvar Pessoa
                </button>
            </div>

        </form>
    </div>
</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
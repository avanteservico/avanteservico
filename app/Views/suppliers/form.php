<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="<?= BASE_URL ?>/suppliers"
                class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">&larr; Voltar para Lista</a>
            <h1 class="text-2xl font-bold text-gray-900">
                <?= isset($supplier) ? 'Editar Fornecedor' : 'Novo Fornecedor' ?>
            </h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
            <form action="<?= isset($supplier) ? BASE_URL . '/suppliers/update' : BASE_URL . '/suppliers/store' ?>"
                method="POST">
                <?php if (isset($supplier)): ?>
                    <input type="hidden" name="id" value="<?= $supplier['id'] ?>">
                <?php endif; ?>

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nome do Fornecedor *</label>
                        <input type="text" name="name" id="name" required
                            value="<?= isset($supplier) ? htmlspecialchars($supplier['name']) : '' ?>"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Telefone / WhatsApp</label>
                        <input type="text" name="phone" id="phone"
                            value="<?= isset($supplier) ? htmlspecialchars($supplier['phone']) : '' ?>"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 mask-phone">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="contact_name" class="block text-sm font-medium text-gray-700">Nome do
                                Contato</label>
                            <input type="text" name="contact_name" id="contact_name"
                                value="<?= isset($supplier) && isset($supplier['contact_name']) ? htmlspecialchars($supplier['contact_name']) : '' ?>"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700">Telefone do
                                Contato</label>
                            <input type="text" name="contact_phone" id="contact_phone"
                                value="<?= isset($supplier) && isset($supplier['contact_phone']) ? htmlspecialchars($supplier['contact_phone']) : '' ?>"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 mask-phone">
                        </div>
                    </div>

                    <div>
                        <label for="observations" class="block text-sm font-medium text-gray-700">Observações</label>
                        <textarea name="observations" id="observations" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"><?= isset($supplier) ? htmlspecialchars($supplier['observations']) : '' ?></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="<?= BASE_URL ?>/suppliers"
                        class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:text-sm">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-blue-800 focus:outline-none sm:text-sm">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
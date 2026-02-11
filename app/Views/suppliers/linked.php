<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Fornecedores por Obra</h1>
        <p class="text-gray-500">Listagem de todos os fornecedores vinculados às obras</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <?php if (empty($linkedData)): ?>
            <div class="p-8 text-center text-gray-400 italic">
                Nenhum vínculo encontrado.
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Obra
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fornecedor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo
                                de Vínculo</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($linkedData as $item): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="<?= BASE_URL ?>/works/show/<?= $item['work_id'] ?>"
                                        class="text-sm font-medium text-primary hover:underline">
                                        <?= htmlspecialchars($item['work_name']) ?>
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="<?= BASE_URL ?>/suppliers/show/<?= $item['supplier_id'] ?>"
                                        class="text-sm text-gray-900 font-medium hover:underline">
                                        <?= htmlspecialchars($item['supplier_name']) ?>
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $item['type'] === 'Vínculo Direto' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' ?>">
                                        <?= htmlspecialchars($item['type']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="<?= BASE_URL ?>/suppliers/show/<?= $item['supplier_id'] ?>"
                                        class="text-blue-600 hover:text-blue-900">Ver Fornecedor</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
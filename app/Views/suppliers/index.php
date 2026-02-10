<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Fornecedores</h1>
            <p class="text-gray-500">Gerenciamento de fornecedores e parceiros</p>
        </div>
        <a href="<?= BASE_URL ?>/suppliers/create"
            class="bg-primary hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow-md transition-colors duration-200 flex items-center text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Novo Fornecedor
        </a>
    </div>

    <!-- Feedback Messages -->
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'true'): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Sucesso!</strong>
            <span class="block sm:inline">Fornecedor excluído com sucesso.</span>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['error']) && $_GET['error'] == 'dependence'): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Erro!</strong>
            <span class="block sm:inline">Não é possível excluir este fornecedor pois existem despesas vinculadas a
                ele.</span>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <?php if (empty($suppliers)): ?>
            <div class="p-8 text-center text-gray-400 italic">
                Nenhum fornecedor cadastrado.
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Telefone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Observações</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($suppliers as $supplier): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars($supplier['name']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= htmlspecialchars($supplier['phone'] ?? '-') ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                    <?= htmlspecialchars($supplier['observations'] ?? '-') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                    <a href="<?= BASE_URL ?>/suppliers/show/<?= $supplier['id'] ?>"
                                        class="text-blue-600 hover:text-blue-900">Detalhes</a>
                                    <a href="<?= BASE_URL ?>/suppliers/edit/<?= $supplier['id'] ?>"
                                        class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                    <?php if ($supplier['id'] != 1): // Don't allow delete default supplier ?>
                                        <a href="<?= BASE_URL ?>/suppliers/delete/<?= $supplier['id'] ?>"
                                            onclick="return confirm('Tem certeza que deseja excluir este fornecedor?')"
                                            class="text-red-600 hover:text-red-900">Excluir</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
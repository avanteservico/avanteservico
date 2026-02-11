<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">

    <!-- Header da Obra -->
    <div class="mb-6">
        <a href="<?= BASE_URL ?>/works/show/<?= $work['id'] ?>"
            class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">&larr;
            Voltar para Detalhes</a>
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Fornecedores da Obra:
                    <?= htmlspecialchars($work['name']) ?>
                </h1>
                <p class="text-gray-500 text-sm mt-1">
                    Gerencie os fornecedores vinculados a esta obra
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <button onclick="document.getElementById('modal-link-supplier').classList.remove('hidden')"
                    class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg shadow-md transition-colors duration-200 flex items-center text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Vincular Fornecedor
                </button>
            </div>
        </div>
    </div>

    <!-- Lista de Fornecedores Vinculados -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <?php if (empty($linkedSuppliers)): ?>
            <div class="p-8 text-center text-gray-400 italic">
                Nenhum fornecedor vinculado a esta obra.
            </div>
        <?php else: ?>
            <ul class="divide-y divide-gray-100">
                <?php foreach ($linkedSuppliers as $supplier): ?>
                    <li
                        class="p-6 hover:bg-gray-50 flex flex-col md:flex-row justify-between items-start md:items-center group">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-amber-100">
                                    <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </span>
                            </div>
                            <div>
                                <a href="<?= BASE_URL ?>/suppliers/show/<?= $supplier['id'] ?>"
                                    class="text-sm font-medium text-gray-900 group-hover:text-primary transition-colors">
                                    <?= htmlspecialchars($supplier['name']) ?>
                                </a>
                                <p class="text-sm text-gray-500">
                                    <?= htmlspecialchars($supplier['phone'] ?? 'Sem telefone') ?>
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0 flex items-center space-x-4">
                            <!-- Lançar Despesa -->
                            <a href="<?= BASE_URL ?>/materials?work_id=<?= $work['id'] ?>&supplier_id=<?= $supplier['id'] ?>&action=new"
                                class="text-xs font-medium bg-amber-50 text-amber-700 px-3 py-1 rounded-full hover:bg-amber-100 transition-colors flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Lançar Despesa
                            </a>

                            <!-- Link para detalhes do fornecedor -->
                            <a href="<?= BASE_URL ?>/suppliers/show/<?= $supplier['id'] ?>"
                                class="text-gray-400 hover:text-primary transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>

                            <!-- Desvincular -->
                            <a href="<?= BASE_URL ?>/works/removeSupplier/<?= $work['id'] ?>?supplier_id=<?= $supplier['id'] ?>"
                                onclick="return confirm('Tem certeza que deseja desvincular este fornecedor desta obra?')"
                                class="text-gray-400 hover:text-red-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- Todos os Fornecedores -->
    <div class="mt-12">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Todos os Fornecedores</h2>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <ul class="divide-y divide-gray-100">
                <?php
                // Helper to check if a supplier is already linked
                $linkedIds = array_column($linkedSuppliers, 'id');
                foreach ($allSuppliers as $supplier):
                    $isLinked = in_array($supplier['id'], $linkedIds);
                    ?>
                    <li
                        class="p-6 hover:bg-gray-50 flex flex-col md:flex-row justify-between items-start md:items-center group">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex items-center justify-center h-10 w-10 rounded-full <?= $isLinked ? 'bg-green-100' : 'bg-gray-100' ?>">
                                    <svg class="h-6 w-6 <?= $isLinked ? 'text-green-600' : 'text-gray-400' ?>" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-900">
                                    <?= htmlspecialchars($supplier['name']) ?>
                                </span>
                                <?php if ($isLinked): ?>
                                    <span
                                        class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Vinculado</span>
                                <?php endif; ?>
                                <p class="text-sm text-gray-500">
                                    <?= htmlspecialchars($supplier['phone'] ?? 'Sem telefone') ?>
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0 flex items-center space-x-3">
                            <!-- Lançar Despesa -->
                            <a href="<?= BASE_URL ?>/materials?work_id=<?= $work['id'] ?>&supplier_id=<?= $supplier['id'] ?>&action=new"
                                class="text-xs font-medium bg-amber-50 text-amber-700 px-3 py-1 rounded-full hover:bg-amber-100 transition-colors flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Lançar Despesa
                            </a>

                            <?php if (!$isLinked): ?>
                                <!-- Formulário rápido para vincular -->
                                <form action="<?= BASE_URL ?>/works/addSupplier" method="POST" class="inline">
                                    <input type="hidden" name="work_id" value="<?= $work['id'] ?>">
                                    <input type="hidden" name="supplier_id" value="<?= $supplier['id'] ?>">
                                    <button type="submit"
                                        class="text-xs font-medium bg-blue-50 text-blue-700 px-3 py-1 rounded-full hover:bg-blue-100 transition-colors flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10.172 13.828a4 4 0 015.656 0l4-4a4 4 0 11-5.656-5.656l-1.102 1.101" />
                                        </svg>
                                        Vincular
                                    </button>
                                </form>
                            <?php endif; ?>

                            <a href="<?= BASE_URL ?>/suppliers/show/<?= $supplier['id'] ?>"
                                class="text-gray-400 hover:text-primary transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<!-- Modal Vincular Fornecedor -->
<div id="modal-link-supplier" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="<?= BASE_URL ?>/works/addSupplier" method="POST">
                <input type="hidden" name="work_id" value="<?= $work['id'] ?>">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Vincular Fornecedor</h3>
                    <div class="mt-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Selecione o Fornecedor</label>
                            <select name="supplier_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                                <option value="">Selecione...</option>
                                <?php foreach ($allSuppliers as $sup): ?>
                                    <option value="<?= $sup['id'] ?>">
                                        <?= htmlspecialchars($sup['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="text-xs text-right mt-1"><a href="<?= BASE_URL ?>/suppliers/create"
                                    class="text-amber-600 hover:underline" target="_blank">Cadastrar novo fornecedor</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-amber-600 text-base font-medium text-white hover:bg-amber-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Vincular</button>
                    <button type="button"
                        onclick="document.getElementById('modal-link-supplier').classList.add('hidden')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
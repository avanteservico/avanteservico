<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:mb-20">
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <a href="<?= BASE_URL ?>/users" class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">&larr;
                Voltar para lista</a>
            <h1 class="text-2xl font-bold text-gray-900">Matriz de Permissões</h1>
            <p class="text-gray-500 text-sm">Usuário: <span
                    class="font-bold text-gray-700"><?= htmlspecialchars($user['name']) ?></span>
                (<?= htmlspecialchars($user['email']) ?>)</p>
        </div>
        <?php if ($user['role'] === 'admin'): ?>
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 max-w-sm">
                <p class="text-xs text-purple-700 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1 mb-0.5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Este usuário é <strong>Administrador</strong> e possui acesso total a todas as funcionalidades
                    automaticamente.
                </p>
            </div>
        <?php endif; ?>
    </div>

    <?php if (isset($success)): ?>
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm">
            <p class="text-green-700 text-sm font-medium"><?= $success ?></p>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/users/permissions/<?= $user['id'] ?>" method="POST">
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden mb-8">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-1/3">
                                Funcionalidade / Módulo</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Listar</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Consultar</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Incluir</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Editar</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Excluir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($resources as $key => $label): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-800"><?= $label ?></td>
                                <td class="px-4 py-4 text-center">
                                    <input type="checkbox" name="permissions[<?= $key ?>][list]" value="1"
                                        <?= (isset($formattedPermissions[$key]['can_list']) && $formattedPermissions[$key]['can_list']) ? 'checked' : '' ?>
                                        class="h-5 w-5 text-primary rounded border-gray-300 focus:ring-primary">
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <input type="checkbox" name="permissions[<?= $key ?>][read]" value="1"
                                        <?= (isset($formattedPermissions[$key]['can_read']) && $formattedPermissions[$key]['can_read']) ? 'checked' : '' ?>
                                        class="h-5 w-5 text-primary rounded border-gray-300 focus:ring-primary">
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <input type="checkbox" name="permissions[<?= $key ?>][create]" value="1"
                                        <?= (isset($formattedPermissions[$key]['can_create']) && $formattedPermissions[$key]['can_create']) ? 'checked' : '' ?>
                                        class="h-5 w-5 text-primary rounded border-gray-300 focus:ring-primary">
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <input type="checkbox" name="permissions[<?= $key ?>][update]" value="1"
                                        <?= (isset($formattedPermissions[$key]['can_update']) && $formattedPermissions[$key]['can_update']) ? 'checked' : '' ?>
                                        class="h-5 w-5 text-primary rounded border-gray-300 focus:ring-primary">
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <input type="checkbox" name="permissions[<?= $key ?>][delete]" value="1"
                                        <?= (isset($formattedPermissions[$key]['can_delete']) && $formattedPermissions[$key]['can_delete']) ? 'checked' : '' ?>
                                        class="h-5 w-5 text-red-600 rounded border-gray-300 focus:ring-red-500">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-between items-center bg-gray-50 p-6 rounded-xl border border-gray-200">
            <div class="text-sm text-gray-500 italic">
                Nota: Marque apenas as funcionalidades que este usuário poderá operar.
            </div>
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-10 py-3 rounded-xl shadow-lg transition-all duration-200 font-bold uppercase tracking-wider text-sm flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Salvar Matriz de Acesso
            </button>
        </div>
    </form>
</div>
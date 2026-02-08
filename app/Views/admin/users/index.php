<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Gestão de Usuários</h1>
            <p class="text-gray-500 text-sm">Controle quem acessa o sistema e quais permissões eles possuem.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?= BASE_URL ?>/users/create"
                class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Novo Usuário
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Usuário</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">E-mail</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Perfil</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Status Senha</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">Nenhum usuário cadastrado.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $u): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900"><?= htmlspecialchars($u['name']) ?></div>
                                    <div class="text-xs text-gray-400">Desde <?= date('d/m/Y', strtotime($u['created_at'])) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars($u['email']) ?></td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $u['role'] === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' ?>">
                                        <?= ucfirst($u['role']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if ($u['must_change_password']): ?>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Troca Obrigatória
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Senha Definida
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-right space-x-3 whitespace-nowrap">
                                    <a href="<?= BASE_URL ?>/users/permissions/<?= $u['id'] ?>"
                                        class="text-xs font-bold text-primary hover:text-blue-800 uppercase tracking-wider"
                                        title="Permissões">
                                        Permissões
                                    </a>
                                    <a href="<?= BASE_URL ?>/users/edit/<?= $u['id'] ?>"
                                        class="text-xs font-bold text-gray-600 hover:text-gray-900 uppercase tracking-wider"
                                        title="Editar">
                                        Editar
                                    </a>
                                    <button onclick="resetPassword(<?= $u['id'] ?>, '<?= htmlspecialchars($u['name']) ?>')"
                                        class="text-xs font-bold text-orange-600 hover:text-orange-800 uppercase tracking-wider"
                                        title="Resetar Senha">
                                        Senha
                                    </button>
                                    <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                        <a href="<?= BASE_URL ?>/users/delete/<?= $u['id'] ?>"
                                            onclick="return confirm('Tem certeza que deseja excluir este usuário?')"
                                            class="text-xs font-bold text-red-600 hover:text-red-800 uppercase tracking-wider"
                                            title="Excluir">
                                            Excluir
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<form id="resetForm" action="<?= BASE_URL ?>/users/resetPassword" method="POST" style="display:none;">
    <input type="hidden" name="id" id="resetId">
    <input type="hidden" name="temp_password" id="resetPass">
</form>

<script>
    function resetPassword(id, name) {
        const pass = prompt(`Defina uma senha temporária para ${name}:`, "123456");
        if (pass) {
            if (pass.length < 6) {
                alert("A senha deve ter pelo menos 6 caracteres.");
                return;
            }
            document.getElementById('resetId').value = id;
            document.getElementById('resetPass').value = pass;
            document.getElementById('resetForm').submit();
        }
    }
</script>

<?php if (isset($_GET['reset']) && $_GET['reset'] === 'success'): ?>
    <script>alert('Senha resetada com sucesso! O usuário precisará alterá-la no próximo acesso.');</script>
<?php elseif (isset($_GET['reset']) && $_GET['reset'] === 'error'): ?>
    <script>alert('Erro ao resetar senha.');</script>
<?php endif; ?>
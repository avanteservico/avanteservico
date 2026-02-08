<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Editar Usuário</h1>
            <p class="text-sm text-gray-500">Atualize os dados básicos de
                <?= htmlspecialchars($user['name']) ?>.
            </p>
        </div>
        <a href="<?= BASE_URL ?>/users" class="text-sm font-medium text-primary hover:underline">
            &larr; Voltar para lista
        </a>
    </div>

    <?php if (isset($error)): ?>
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">
                <?= $error ?>
            </span>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <form action="<?= BASE_URL ?>/users/update" method="POST" class="p-6 space-y-6">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
                <input type="text" name="name" id="name" required value="<?= htmlspecialchars($user['name']) ?>"
                    class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail de Acesso</label>
                <input type="email" name="email" id="email" required value="<?= htmlspecialchars($user['email']) ?>"
                    class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Perfil de Acesso</label>
                <select name="role" id="role" required
                    class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Usuário Padrão</option>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>

            <div class="pt-4 flex items-center justify-end space-x-4 border-t border-gray-100">
                <a href="<?= BASE_URL ?>/users"
                    class="text-sm font-medium text-gray-400 hover:text-gray-600">Cancelar</a>
                <button type="submit"
                    class="px-6 py-2 bg-primary text-white rounded-lg font-bold shadow-md hover:bg-blue-800 transition-all active:scale-95">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
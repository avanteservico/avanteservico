<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <a href="<?= BASE_URL ?>/users" class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">&larr;
            Voltar para lista</a>
        <h1 class="text-2xl font-bold text-gray-900">Novo Usuário</h1>
        <p class="text-gray-500 text-sm">Cadastre um novo colaborador e defina sua senha temporária.</p>
    </div>

    <?php if (isset($error)): ?>
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
            <p class="text-red-700 text-sm">
                <?= $error ?>
            </p>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <form action="<?= BASE_URL ?>/users/create" method="POST" class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nome Completo</label>
                    <input type="text" name="name" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">E-mail (Login)</label>
                    <input type="email" name="email" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Senha Temporária</label>
                    <input type="password" name="password" required minlength="6"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        placeholder="Mínimo 6 caracteres">
                    <p class="mt-1 text-xs text-gray-400 italic">O usuário deverá trocar esta senha no primeiro login.
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Perfil de Acesso</label>
                    <select name="role" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <option value="user">Usuário Comum (Baseado em Matriz)</option>
                        <option value="admin">Administrador (Acesso Total)</option>
                    </select>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit"
                    class="bg-primary hover:bg-blue-800 text-white px-8 py-3 rounded-xl shadow-md transition-colors duration-200 font-bold uppercase tracking-wider text-xs">
                    Criar Usuário
                </button>
            </div>
        </form>
    </div>
</div>
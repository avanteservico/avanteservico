<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Meu Perfil</h1>
        <p class="text-gray-500 text-sm">Gerencie suas informações e senha</p>
    </div>

    <?php if (isset($success)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">
                <?= $success ?>
            </span>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">
                <?= $error ?>
            </span>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="font-bold text-gray-800">Informações Pessoais</h3>
        </div>
        <form action="<?= BASE_URL ?>/profile/update" method="POST" class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nome Completo</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">E-mail (Login)</label>
                    <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled
                        class="mt-1 block w-full rounded-md border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed shadow-none">
                    <p class="mt-1 text-xs text-gray-400 italic">O e-mail não pode ser alterado.</p>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100">
                <h4 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Segurança</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nova Senha</label>
                        <input type="password" name="password" placeholder="Deixe em branco para não alterar"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit"
                    class="bg-primary hover:bg-blue-800 text-white px-6 py-2 rounded-lg shadow-md transition-colors duration-200 font-medium">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
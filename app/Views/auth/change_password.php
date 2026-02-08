<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trocar Senha - Avante Serviço</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
        <div class="p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Segurança da Conta</h1>
                <p class="text-gray-500 text-sm">Este é o seu primeiro acesso. Por favor, defina uma nova senha para
                    continuar.</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
                    <p class="text-red-700 text-sm italic">
                        <?= $error ?>
                    </p>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/auth/change-password" method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nova Senha</label>
                    <input type="password" name="password" required minlength="6"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all"
                        placeholder="Mínimo 6 caracteres">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Confirmar Senha</label>
                    <input type="password" name="password_confirm" required minlength="6"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all"
                        placeholder="Repita a nova senha">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                    Atualizar Senha e Entrar
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="<?= BASE_URL ?>/auth/logout"
                    class="text-sm text-gray-500 hover:text-gray-700 underline decoration-gray-300">Sair do sistema</a>
            </div>
        </div>
    </div>
</body>

</html>
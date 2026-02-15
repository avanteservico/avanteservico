<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">
    <div class="mb-6">
        <a href="<?= BASE_URL ?>/works/show/<?= $work['id'] ?>"
            class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">&larr; Voltar para Obra</a>
        <h1 class="text-2xl font-bold text-gray-900">Painel Financeiro</h1>
        <p class="text-gray-500 text-sm">Obra: <?= htmlspecialchars($work['name']) ?></p>
    </div>

    <!-- Resumo Geral da Obra -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-sm font-medium text-gray-500 mb-2 uppercase tracking-wider">Total em Receitas</h3>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-bold text-green-600">R$
                    <?= number_format($totalIncomes, 2, ',', '.') ?>
                </span>
            </div>
            <div class="mt-2 text-xs">
                <span class="text-green-500 font-medium">R$
                    <?= number_format($revenueSummary['total_received'] ?? 0, 2, ',', '.') ?> recebido
                </span>
                <span class="text-gray-400 mx-1">•</span>
                <span class="text-gray-500">R$
                    <?= number_format($revenueSummary['total_to_receive'] ?? 0, 2, ',', '.') ?> previsto
                </span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-sm font-medium text-gray-500 mb-2 uppercase tracking-wider">Total em Despesas</h3>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-bold text-red-600">R$
                    <?= number_format($totalExpenses, 2, ',', '.') ?>
                </span>
            </div>
            <div class="mt-2 text-xs">
                <span class="text-red-500 font-medium">R$
                    <?= number_format(($materialSummary['total_paid'] ?? 0) + ($paymentSummary['total_paid'] ?? 0), 2, ',', '.') ?>
                    pago
                </span>
                <span class="text-gray-400 mx-1">•</span>
                <span class="text-gray-500">R$
                    <?= number_format(($materialSummary['total_pending'] ?? 0) + ($paymentSummary['total_pending'] ?? 0), 2, ',', '.') ?>
                    pendente
                </span>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-<?= $balance >= 0 ? 'green' : 'red' ?>-200 bg-opacity-50">
            <h3 class="text-sm font-medium text-gray-500 mb-2 uppercase tracking-wider">Saldo da Obra</h3>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-bold text-<?= $balance >= 0 ? 'green' : 'red' ?>-700">R$
                    <?= number_format($balance, 2, ',', '.') ?>
                </span>
            </div>
            <p class="mt-2 text-xs text-gray-500">
                Diferença entre receitas e despesas desta obra
            </p>
        </div>
    </div>

    <!-- Gestão Detalhada -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="<?= BASE_URL ?>/revenues?work_id=<?= $work['id'] ?>"
            class="flex items-center p-6 bg-white rounded-xl shadow-sm border border-gray-200 hover:border-primary hover:shadow-md transition-all group">
            <div
                class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center mr-4 group-hover:bg-green-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <span
                    class="block text-lg font-bold text-gray-900 group-hover:text-primary transition-colors">Receitas</span>
                <span class="text-xs text-gray-500 italic">Lançamentos e recebimentos</span>
            </div>
        </a>

        <a href="<?= BASE_URL ?>/materials?work_id=<?= $work['id'] ?>"
            class="flex items-center p-6 bg-white rounded-xl shadow-sm border border-gray-200 hover:border-primary hover:shadow-md transition-all group">
            <div
                class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center mr-4 group-hover:bg-blue-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div>
                <span
                    class="block text-lg font-bold text-gray-900 group-hover:text-primary transition-colors">Materiais</span>
                <div class="flex items-center text-[11px] mt-0.5">
                    <span class="text-green-600 font-semibold">R$
                        <?= number_format($materialSummary['total_paid'] ?? 0, 2, ',', '.') ?></span>
                    <span class="text-gray-300 mx-1.5">|</span>
                    <span class="text-red-500 font-semibold">R$
                        <?= number_format($materialSummary['total_pending'] ?? 0, 2, ',', '.') ?></span>
                </div>
            </div>
        </a>

        <a href="<?= BASE_URL ?>/people?work_id=<?= $work['id'] ?>"
            class="flex items-center p-6 bg-white rounded-xl shadow-sm border border-gray-200 hover:border-primary hover:shadow-md transition-all group">
            <div
                class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center mr-4 group-hover:bg-purple-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <span
                    class="block text-lg font-bold text-gray-900 group-hover:text-primary transition-colors">Equipe</span>
                <div class="flex items-center text-[11px] mt-0.5">
                    <span class="text-green-600 font-semibold">R$
                        <?= number_format($paymentSummary['total_paid'] ?? 0, 2, ',', '.') ?></span>
                    <span class="text-gray-300 mx-1.5">|</span>
                    <span class="text-red-500 font-semibold">R$
                        <?= number_format($paymentSummary['total_pending'] ?? 0, 2, ',', '.') ?></span>
                </div>
            </div>
        </a>
    </div>
</div>
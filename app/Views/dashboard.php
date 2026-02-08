<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">

    <!-- Welcome Section -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Olá,
                <?= $_SESSION['user_name'] ?> 👋
            </h1>
            <p class="text-sm text-gray-500">Visão geral dos seus projetos.</p>
        </div>
        <a href="<?= BASE_URL ?>/works/create"
            class="bg-primary hover:bg-blue-800 text-white p-3 rounded-full shadow-lg transition-transform transform active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </a>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">Obras Ativas</div>
            <div class="text-2xl font-bold text-gray-900">
                <?= $summary['active_works'] ?? 0 ?>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">Total Obras</div>
            <div class="text-2xl font-bold text-gray-900">
                <?= $summary['total_works'] ?? 0 ?>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 col-span-2 md:col-span-2">
            <div class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">Valor em Carteira</div>
            <div class="text-2xl font-bold text-primary">R$
                <?= number_format($summary['total_value'] ?? 0, 2, ',', '.') ?>
            </div>
        </div>
    </div>

    <!-- Recent Works List -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Obras Recentes</h2>
            <a href="<?= BASE_URL ?>/works" class="text-sm text-primary font-medium hover:underline">Ver todas</a>
        </div>

        <div class="space-y-4">
            <?php if (empty($works)): ?>
                <p class="text-center text-gray-500 py-8">Nenhuma obra cadastrada.</p>
            <?php else: ?>
                <?php foreach (array_slice($works, 0, 5) as $work): ?>
                    <a href="<?= BASE_URL ?>/works/show/<?= $work['id'] ?>"
                        class="block bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-gray-900">
                                    <?= htmlspecialchars($work['name']) ?>
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">
                                    <?= htmlspecialchars($work['address']) ?>
                                </p>
                            </div>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <?= $work['status'] ?>
                            </span>
                        </div>
                        <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                            <span>Início:
                                <?= date('d/m/Y', strtotime($work['start_date'])) ?>
                            </span>
                            <span>Prazo:
                                <?= date('d/m/Y', strtotime($work['end_date_prediction'])) ?>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</div>

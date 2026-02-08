<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">

    <!-- Header da Obra -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <div class="flex items-center space-x-3 text-sm text-gray-500 mb-1">
                    <a href="<?= BASE_URL ?>/works" class="hover:text-primary">Obras</a>
                    <span>/</span>
                    <span>Detalhes</span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">
                    <?= htmlspecialchars($work['name']) ?>
                </h1>
                <p class="text-gray-500 flex items-center mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <?= htmlspecialchars($work['address']) ?>
                </p>
            </div>
            <div class="mt-4 md:mt-0 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-3">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $work['status'] == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                    <?= ucfirst($work['status']) ?>
                </span>
                <a href="<?= BASE_URL ?>/works/edit/<?= $work['id'] ?>" class="text-gray-500 hover:text-primary p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6 pt-6 border-t border-gray-100">
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase">Valor Total</p>
                <p class="text-xl font-bold text-primary">R$
                    <?= number_format($work['total_value'], 2, ',', '.') ?>
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase">Data Início</p>
                <p class="text-sm font-semibold text-gray-700">
                    <?= date('d/m/Y', strtotime($work['start_date'])) ?>
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase">Previsão Término</p>
                <p class="text-sm font-semibold text-gray-700">
                    <?= date('d/m/Y', strtotime($work['end_date_prediction'])) ?>
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase">Ponto Referência</p>
                <p class="text-sm text-gray-600">
                    <?= htmlspecialchars($work['reference_point']) ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Modulos Rápidos -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <a href="<?= BASE_URL ?>/services?work_id=<?= $work['id'] ?>"
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow text-center group">
            <div
                class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900">Serviços</h3>
            <p class="text-xs text-gray-500 mt-1">Gerenciar etapas</p>
        </a>

        <a href="<?= BASE_URL ?>/people?work_id=<?= $work['id'] ?>"
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow text-center group">
            <div
                class="w-12 h-12 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-purple-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900">Equipe</h3>
            <p class="text-xs text-gray-500 mt-1">Pessoas e Pagamentos</p>
        </a>

        <a href="<?= BASE_URL ?>/financial?work_id=<?= $work['id'] ?>"
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow text-center group">
            <div
                class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-green-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900">Financeiro</h3>
            <p class="text-xs text-gray-500 mt-1">Receitas e Despesas</p>
        </a>

        <a href="<?= BASE_URL ?>/tasks?work_id=<?= $work['id'] ?>"
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow text-center group">
            <div
                class="w-12 h-12 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-orange-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900">Tarefas</h3>
            <p class="text-xs text-gray-500 mt-1">Kanban e Prazos</p>
        </a>
    </div>

</div>
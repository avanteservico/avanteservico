<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Obras</h1>
        <a href="<?= BASE_URL ?>/works/create"
            class="bg-primary hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow-md transition-colors duration-200 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nova Obra
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($works)): ?>
            <div class="col-span-full text-center py-12 bg-white rounded-xl shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <p class="text-gray-500 text-lg">Nenhuma obra cadastrada.</p>
                <p class="text-gray-400 text-sm mt-2">Comece criando seu primeiro projeto.</p>
            </div>
        <?php else: ?>
            <?php foreach ($works as $work): ?>
                <a href="<?= BASE_URL ?>/works/show/<?= $work['id'] ?>"
                    class="block bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h2 class="text-xl font-bold text-gray-900 line-clamp-1">
                                <?= htmlspecialchars($work['name']) ?>
                            </h2>
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $work['status'] == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                <?= ucfirst($work['status']) ?>
                            </span>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <?= htmlspecialchars($work['address']) ?>
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Previsão:
                                <?= date('d/m/Y', strtotime($work['end_date_prediction'])) ?>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-4 mt-4">
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-xs text-gray-400 font-medium uppercase">Valor Total</p>
                                    <p class="text-lg font-bold text-primary">R$
                                        <?= number_format($work['total_value'], 2, ',', '.') ?>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <!-- Placeholder para progresso -->
                                    <p class="text-xs text-gray-400 font-medium uppercase mb-1">Concluído</p>
                                    <div class="w-24 bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-green-500 h-2.5 rounded-full" style="width: 0%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">0%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
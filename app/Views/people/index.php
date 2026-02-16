<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Pessoas</h1>
        <a href="<?= BASE_URL ?>/people/create"
            class="bg-primary hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow-md transition-colors duration-200 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nova Pessoa
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($people)): ?>
            <div class="col-span-full text-center py-12 bg-white rounded-xl shadow-sm">
                <p class="text-gray-500">Nenhuma pessoa cadastrada.</p>
            </div>
        <?php else: ?>
            <?php foreach ($people as $person): ?>
                <a href="<?= BASE_URL ?>/people/show/<?= $person['id'] ?>"
                    class="block bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 transform hover:-translate-y-1 group">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-primary font-bold text-lg group-hover:bg-primary group-hover:text-white transition-colors">
                            <?= strtoupper(substr($person['name'], 0, 1)) ?>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">
                                <?= htmlspecialchars($person['name']) ?>
                            </h2>
                            <p class="text-sm text-gray-500">
                                <?= htmlspecialchars($person['role']) ?> •
                                <?= ucfirst($person['service_type']) ?>
                            </p>
                        </div>
                    </div>
                    <?php if ($person['nickname']): ?>
                        <p class="mt-4 text-xs text-gray-400 font-medium uppercase tracking-wide">Apelido</p>
                        <p class="text-sm text-gray-600">
                            <?= htmlspecialchars($person['nickname']) ?>
                        </p>
                    <?php endif; ?>
                    <?php if ($person['phone']): ?>
                        <p class="mt-2 text-xs text-gray-400 font-medium uppercase tracking-wide">Telefone</p>
                        <p class="text-sm text-gray-600">
                            <?= htmlspecialchars($person['phone']) ?>
                        </p>
                    <?php endif; ?>

                    <div class="mt-4 pt-4 border-t border-gray-50 grid grid-cols-2 gap-2">
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Recebido</p>
                            <p class="text-sm font-bold text-green-600">
                                R$ <?= number_format($person['total_paid'], 2, ',', '.') ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">A Receber</p>
                            <p class="text-sm font-bold text-red-500">
                                R$ <?= number_format($person['total_pending'], 2, ',', '.') ?>
                            </p>
                        </div>
                    </div>
                </a>
                <div class="mt-2 flex justify-end px-2">
                    <a href="<?= BASE_URL ?>/people/edit/<?= $person['id'] ?>"
                        class="text-xs text-blue-600 hover:text-blue-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Editar
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
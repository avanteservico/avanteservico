<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-20">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pessoas</h1>
            <?php if ($work): ?>
                <p class="text-sm text-gray-500 mt-1">
                    Equipe da obra: <span class="font-semibold text-primary"><?= htmlspecialchars($work['name']) ?></span>
                    <a href="<?= BASE_URL ?>/people" class="ml-2 text-xs text-gray-400 hover:text-primary underline">Ver
                        todas</a>
                </p>
            <?php endif; ?>
        </div>
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
            <div class="col-span-full text-center py-12 bg-white rounded-xl shadow-sm border border-gray-100">
                <p class="text-gray-500">Nenhuma pessoa encontrada <?php echo $work ? 'nesta obra' : 'cadastrada'; ?>.</p>
            </div>
        <?php else: ?>
            <?php foreach ($people as $person): ?>
                <div
                    class="relative bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
                    <!-- Link Principal para Detalhes (Overlay) -->
                    <a href="<?= BASE_URL ?>/people/show/<?= $person['id'] ?>" class="absolute inset-0 z-0"
                        aria-label="Ver detalhes de <?= htmlspecialchars($person['name']) ?>"></a>

                    <div class="relative z-10 pointer-events-none">
                        <div class="flex items-center space-x-4">
                            <div
                                class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-primary font-bold text-lg group-hover:bg-primary group-hover:text-white transition-colors">
                                <?= strtoupper(substr($person['name'] ?? 'P', 0, 1)) ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h2 class="text-lg font-bold text-gray-900 flex items-center truncate">
                                    <?= htmlspecialchars($person['name']) ?>
                                    <!-- Botão de Editar (com pointer-events-auto para ser clicável) -->
                                    <a href="<?= BASE_URL ?>/people/edit/<?= $person['id'] ?>"
                                        class="ml-2 p-1 text-gray-400 hover:text-primary transition-colors pointer-events-auto relative z-20"
                                        title="Editar Cadastro">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>
                                </h2>
                                <p class="text-sm text-gray-500 truncate">
                                    <?= htmlspecialchars($person['role']) ?> •
                                    <?= ucfirst($person['service_type']) ?>
                                </p>
                            </div>
                        </div>

                        <?php if ($person['nickname']): ?>
                            <div class="mt-4">
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Apelido</p>
                                <p class="text-sm text-gray-600 truncate">
                                    <?= htmlspecialchars($person['nickname']) ?>
                                </p>
                            </div>
                        <?php endif; ?>

                        <?php if ($person['phone']): ?>
                            <div class="mt-2 text-xs text-gray-400 font-medium uppercase tracking-wide">Telefone</div>
                            <div class="text-sm text-gray-600">
                                <?= htmlspecialchars($person['phone']) ?>
                            </div>
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
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
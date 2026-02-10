<?php if (AuthHelper::isLoggedIn()): ?>
    <!-- Espaçamento para não cobrir conteúdo com a navbar fixa -->
    <div class="h-20"></div>

    <!-- Bottom Navigation Bar -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50 pb-safe">
        <div class="flex justify-around items-center h-16">
            <a href="<?= BASE_URL ?>/dashboard"
                class="flex flex-col items-center justify-center w-full h-full text-gray-500 hover:text-primary active:text-primary transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xs font-medium">Home</span>
            </a>

            <a href="<?= BASE_URL ?>/services"
                class="flex flex-col items-center justify-center w-full h-full text-gray-500 hover:text-primary active:text-primary transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span class="text-xs font-medium">Obras</span>
            </a>

            <a href="<?= BASE_URL ?>/suppliers"
                class="flex flex-col items-center justify-center w-full h-full text-gray-500 hover:text-primary active:text-primary transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span class="text-xs font-medium">Fornecedores</span>
            </a>

            <div class="relative -top-5">
                <a href="<?= BASE_URL ?>/tasks"
                    class="flex flex-col items-center justify-center w-14 h-14 rounded-full bg-primary text-white shadow-lg transform active:scale-95 transition-transform duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </a>
            </div>


            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="<?= BASE_URL ?>/users"
                    class="flex flex-col items-center justify-center w-full h-full text-gray-500 hover:text-primary active:text-primary transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="text-xs font-medium">Usuários</span>
                </a>
            <?php endif; ?>

            <a href="<?= BASE_URL ?>/profile"
                class="flex flex-col items-center justify-center w-full h-full text-gray-500 hover:text-primary active:text-primary transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-xs font-medium">Perfil</span>
            </a>
        </div>
    </nav>
<?php endif; ?>

<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('<?= BASE_URL ?>/sw.js')
                .then(registration => {
                    console.log('SW registered: ', registration);
                })
                .catch(registrationError => {
                    console.log('SW registration failed: ', registrationError);
                });
        });
    }

    // Máscaras de Input (Moeda e Porcentagem)
    document.addEventListener('DOMContentLoaded', function () {
        const moneyInputs = document.querySelectorAll('.mask-money');
        const percentInputs = document.querySelectorAll('.mask-percent');

        function formatValue(value) {
            value = value.replace(/\D/g, "");
            if (value === "") return "";
            return (parseInt(value) / 100).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function applyMask(input, isPercent = false) {
            input.addEventListener('input', (e) => {
                let val = e.target.value.replace(/\D/g, "");
                if (val === "") {
                    e.target.value = "";
                } else {
                    if (isPercent) {
                        let num = parseInt(val) / 100;
                        if (num > 100) {
                            val = "10000"; // Fixa em 100,00
                        }
                    }
                    e.target.value = formatValue(val);
                }

                // Trigger custom event for calculation if needed
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });

            // Formatar valor inicial vindo do PHP
            if (input.value) {
                let val = input.value.replace(',', '.');
                if (!isNaN(val) && val !== "") {
                    input.value = parseFloat(val).toLocaleString('pt-BR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            }
        }

        moneyInputs.forEach(input => applyMask(input, false));
        percentInputs.forEach(input => applyMask(input, true));
    });
</script>
</body>

</html>
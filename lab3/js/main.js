function initTheme() {
    const themeBtn = document.getElementById('theme-toggle');
    if (!themeBtn) return;

    const savedTheme = localStorage.getItem('theme');
    const currentTheme = (savedTheme === 'dark') ? 'dark' : 'light';

    document.documentElement.setAttribute('data-theme', currentTheme);
    themeBtn.setAttribute('aria-pressed', currentTheme === 'dark');

    themeBtn.addEventListener('click', () => {
        const activeTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = (activeTheme === 'dark') ? 'light' : 'dark';

        document.documentElement.setAttribute('data-theme', newTheme);
        themeBtn.setAttribute('aria-pressed', newTheme === 'dark');
        localStorage.setItem('theme', newTheme);
    });
}


function initClock() {
    const display = document.getElementById('clock-display');
    const startBtn = document.getElementById('clock-start');
    const stopBtn = document.getElementById('clock-stop');

    if (!display || !startBtn || !stopBtn) return;

    let timerId = null;

    const formatter = new Intl.DateTimeFormat('pl-PL', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    });

    function updateTime() {
        display.textContent = formatter.format(new Date());
    }

    function startClock() {
        if (timerId !== null) return;
        updateTime();
        timerId = setInterval(updateTime, 1000);
    }

    function stopClock() {
        if (timerId !== null) {
            clearInterval(timerId);
            timerId = null;
        }
    }

    startBtn.addEventListener('click', startClock);
    stopBtn.addEventListener('click', stopClock);

    startClock();
}

// --- Obsługa wyszukiwarki produktów (Punkt 4) ---
function initSearch() {
    const searchInput = document.getElementById('product-search');
    const cards = document.querySelectorAll('.product-card');
    const noResults = document.getElementById('no-results');
    const counter = document.getElementById('search-counter');

    if (!searchInput || cards.length === 0) return;

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        cards.forEach(card => {
            const titleEl = card.querySelector('h2');
            const title = titleEl ? titleEl.textContent.toLowerCase() : '';
            const matches = title.includes(query);

            if (matches) {
                card.removeAttribute('hidden');
                visibleCount++;
            } else {
                card.setAttribute('hidden', '');
            }
        });

        if (counter) {
            counter.textContent = `Liczba wyników: ${visibleCount}`;
        }

        if (noResults) {
            if (visibleCount === 0) {
                noResults.removeAttribute('hidden');
            } else {
                noResults.setAttribute('hidden', '');
            }
        }
    });
}
// --- 5. Oblicz wartość i pokaż podsumowanie ---
function calculateTotalGrosze(cenaGrosze, ilosc) {
    return cenaGrosze * ilosc;
}

function initOrderForm() {
    const form = document.getElementById('kontakt-form');
    if (!form) return;

    const products = [
        { id: 'mikasa-v200w', nazwa: 'Piłka siatkarska Mikasa V200W', cenaGrosze: 39900 },
        { id: 'koszulka-zaksa', nazwa: 'Koszulka meczowa ZAKSA Kędzierzyn-Koźle', cenaGrosze: 22900 },
        { id: 'nakolanniki-mizuno', nazwa: 'Nakolanniki siatkarskie Mizuno', cenaGrosze: 8900 }
    ];

    const plnFormatter = new Intl.NumberFormat('pl-PL', {
        style: 'currency',
        currency: 'PLN'
    });

    const productSelect = document.getElementById('produkt');
    const quantityInput = document.getElementById('ilosc');
    const livePrice = document.getElementById('live-price');
    const messageInput = document.getElementById('wiadomosc');
    const messageError = document.getElementById('message-error');
    const summarySection = document.getElementById('order-summary');

    function updateLiveCalculation() {
        if (summarySection) summarySection.hidden = true;

        const val = Number(quantityInput.value);
        if (!Number.isInteger(val) || val < 1 || val > 5) {
            livePrice.textContent = 'Proszę podać poprawną liczbę sztuk (liczba całkowita od 1 do 5).';
            return null;
        }

        const selectedProduct = products.find(p => p.id === productSelect.value);
        if (!selectedProduct) return null;

        const totalGrosze = calculateTotalGrosze(selectedProduct.cenaGrosze, val);
        const formattedPrice = plnFormatter.format(totalGrosze / 100);

        livePrice.textContent = `Wartość: ${formattedPrice}`;
        return { product: selectedProduct, quantity: val, totalFormatted: formattedPrice };
    }

    productSelect.addEventListener('change', updateLiveCalculation);
    quantityInput.addEventListener('input', updateLiveCalculation);

    messageInput.addEventListener('input', () => {
        if (summarySection) summarySection.hidden = true;
        if (messageInput.value.trim().length >= 10) {
            messageError.hidden = true;
            messageError.textContent = '';
        }
    });

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const calcData = updateLiveCalculation();
        const msgText = messageInput.value.trim();

        if (msgText.length < 10) {
            messageError.textContent = 'Wiadomość musi mieć co najmniej 10 znaków.';
            messageError.hidden = false;
            messageInput.focus();
            return;
        } else {
            messageError.hidden = true;
            messageError.textContent = '';
        }

        if (!calcData) {
            quantityInput.focus();
            return;
        }

        document.getElementById('sum-product').textContent = calcData.product.nazwa;
        document.getElementById('sum-qty').textContent = calcData.quantity;
        document.getElementById('sum-total').textContent = calcData.totalFormatted;
        document.getElementById('sum-msg').textContent = msgText;

        summarySection.hidden = false;
    });

    updateLiveCalculation();
}



initTheme();
initClock();
initSearch();
initOrderForm();

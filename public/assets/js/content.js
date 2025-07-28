document.addEventListener('DOMContentLoaded', function() {
    
    const cards = document.getElementById('container').children;
    const contentDico = {};

    for (const card of cards){
        if (!card.classList.contains('card')) continue;

        contentDico[card.getAttribute('content-key')] = card;

        // Open card event
        card.getElementsByTagName('p')[0].onclick = () => {
            card.classList.toggle('card-open');
        }

    }

    const search = document.getElementById('search');
    const no_result = document.getElementById('no-result');

    search.onkeyup = () => {
        const value = search.value.toLowerCase();

        // If the search input is empty, show all cards
        if (value === '') {
            for (const key in contentDico) {
                contentDico[key].style.display = '';
            }
            no_result.style.display = 'none';
            return;
        }

        // Otherwise, filter the cards based on the search input
        for (const key in contentDico) {
            if (key.toLowerCase().includes(value)) {
                contentDico[key].style.display = '';
            } else {
                contentDico[key].style.display = 'none';
            }
        }
        
        // If no cards are found, show a message
        if (Array.from(cards).filter(card => card.style.display !== 'none').length === 0) {
            no_result.style.display = 'block';
        } else {
            no_result.style.display = 'none';
        }

    }

});
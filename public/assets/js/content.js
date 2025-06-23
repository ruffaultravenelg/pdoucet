const cards = Array.from(document.getElementById('container').children).filter(card => card.classList.contains('card'));
const content = {};

for (const card of cards){

    content[card.getAttribute('content-name')] = card;

    // Open card event
    card.getElementsByTagName('p')[0].onclick = () => {
        card.classList.toggle('card-open');
    }

    // Update value event
    card.getElementsByTagName('button')

}

const search = document.getElementById('search');
const no_result = document.getElementById('no-result');

search.onkeyup = () => {
    const value = search.value.toLowerCase();

    // If the search input is empty, show all cards
    if (value === '') {
        for (const key in content) {
            content[key].style.display = '';
        }
        no_result.style.display = 'none';
        return;
    }

    // Otherwise, filter the cards based on the search input
    for (const key in content) {
        if (key.toLowerCase().includes(value)) {
            content[key].style.display = '';
        } else {
            content[key].style.display = 'none';
        }
    }    

    // If no cards are found, show a message
    if (Array.from(cards).filter(card => card.style.display !== 'none').length === 0) {
        no_result.style.display = 'block';
    } else {
        no_result.style.display = 'none';
    }

}
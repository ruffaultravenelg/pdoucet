const url_field = document.getElementById('url_field');
const page_selector = document.getElementById('index_link_page');

function updateUrlFieldVisibility() {
    if (page_selector.value) {
        url_field.style.height = '0';
        url_field.style.overflow = 'hidden';
    } else {
        url_field.style.height = 'auto';
    }
}

page_selector.onchange = updateUrlFieldVisibility;
document.addEventListener('DOMContentLoaded', updateUrlFieldVisibility);
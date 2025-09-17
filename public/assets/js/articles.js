const filterForm = document.querySelector('.content-wrapper > form');
const filterHiddenOnly = document.querySelector('#h');

if (filterHiddenOnly) filterHiddenOnly.addEventListener('change', () => {
    filterForm.requestSubmit();
});
const itemContainer = document.getElementById("container");
const redirect_type = document.getElementById("redirect_type");
const link_panel = document.getElementById("link_panel");
const page_panel = document.getElementById("page_panel");
const page_select = document.getElementById('page_select');
const link_title = document.getElementById('link_title');
const link_url = document.getElementById('link_url');
const delete_panel = document.getElementById('delete_panel');
const edit_container = document.getElementById('edit_container');
const new_item = document.getElementById('new_item');

// For draggability
let headerItems = window.headerItems || [];
const firstPageId = document.getElementById('page_select').children[0].value || '';

let draggedItem = null;
function refreshDisplay(){

    while (itemContainer.firstChild)
        itemContainer.removeChild(itemContainer.firstChild);

    headerItems.forEach(i => {

        const item = document.createElement("div");
        item.textContent = i.pageId
            ? (Array.from(page_select.options).find(opt => opt.value === i.pageId)?.text || '')
            : i.title;
        item.setAttribute('data-title', i.title || '');
        item.setAttribute('data-pageId', i.pageId || '');
        item.setAttribute('data-path', i.path || '');
        item.setAttribute("draggable", "true");
        itemContainer.appendChild(item);

        item.addEventListener("dragstart", () => {
            draggedItem = item;
            item.classList.add("dragging");
        });

        item.addEventListener("dragend", () => {
            draggedItem = null;
            item.classList.remove("dragging");
        });

        item.addEventListener("dragover", (e) => {
            e.preventDefault(); // Necessary to allow drop
            const list = item.parentNode;
            const bounding = item.getBoundingClientRect();
            const offset = e.clientX - bounding.left + bounding.width / 2;

            if (offset > bounding.width) {
                list.insertBefore(draggedItem, item.nextSibling);
            } else {
                list.insertBefore(draggedItem, item);
            }
        });

        item.addEventListener('click', () => {
            
            for (let child of itemContainer.children) {
                child.classList.remove('selected');
            }
            item.classList.add('selected');

            redirect_type.value = item.getAttribute('data-pageId') ? 'page' : 'link';

            function updatePanels() {
                if (item.getAttribute('data-pageId')) {
                    link_panel.hidden = true;
                    page_panel.hidden = false;
                    page_select.value = item.getAttribute('data-pageId') || firstPageId;
                    item.textContent = page_select.options[page_select.selectedIndex].text;
                } else {
                    link_panel.hidden = false;
                    page_panel.hidden = true;
                    item.textContent = item.getAttribute('data-title') || '';
                    link_title.value = item.getAttribute('data-title') || '';
                    link_url.value = item.getAttribute('data-path') || '';
                }
            }

            updatePanels();
            redirect_type.onchange = ()=>{
                if (redirect_type.value === 'page') {
                    item.setAttribute('data-pageId', firstPageId);
                } else {
                    item.setAttribute('data-pageId', '');
                }
                updatePanels();
            };

            page_select.onchange = () => {
                item.setAttribute('data-pageId', page_select.value);
                updatePanels();
            }

            link_title.oninput = () => {
                item.setAttribute('data-title', link_title.value);
                item.textContent = link_title.value;
            };

            link_url.oninput = () => {
                item.setAttribute('data-path', link_url.value);
            };

            delete_panel.onclick = () => {
                swal({
                    title: "Êtes vous sûr ?",
                    text: "Cette action est irréversible.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete){
                        itemContainer.removeChild(item);
                        selectFirst();
                    }
                });
            }

        });

    });

}
refreshDisplay();

function selectFirst(){
    if (itemContainer.children.length === 0) {
        edit_container.style.display = 'none';
    } else {
        edit_container.style.display = 'flex';
        itemContainer.firstChild.click();
    }
}
selectFirst();

new_item.onclick = () => {
    const item = document.createElement("div");
    item.textContent = 'Nouveau lien';
    item.setAttribute('data-title', 'Nouveau lien');
    item.setAttribute('data-pageId', '');
    item.setAttribute('data-path', '/');
    itemContainer.appendChild(item);
    headerItems = getHeaderLinksFromDOM();
    refreshDisplay();
    
    item.click();
}


function getHeaderLinksFromDOM(){
    const newOrder = Array.from(itemContainer.children).map(item => ({
        title: item.getAttribute('data-title'),
        path: item.getAttribute('data-path'),
        pageId: item.getAttribute('data-pageId'),
    }));
    newOrder.forEach(obj => {
        if (obj.pageId === null || obj.pageId === '' || obj.pageId === 'null' || obj.pageId === 'undefined') {
            delete obj.pageId;
        } else {
            delete obj.path;
            delete obj.title;
        }
    });
    return newOrder;
}

// Saving
document.getElementById('save').onclick = () => {


    const form = document.createElement('form');
    form.style.display = 'none';
    document.body.appendChild(form);

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'headerItems';
    input.value = JSON.stringify(getHeaderLinksFromDOM());
    form.appendChild(input);

    form.method = 'POST';
    form.action = '/header/update';

    form.submit();
}

// Loading pages selector
redirect_type
const delete_btns = Array.from(document.querySelectorAll('button.confirmDialog')).filter(btn => btn.hasAttribute('action'));

// Add event listeners to all delete buttons
for (const delete_btn of delete_btns) {
    delete_btn.addEventListener('click', (e)=>{
        swal({
            title: "Êtes vous sûr ?",
            text: "Cette action est irréversible.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) window.location.href = delete_btn.getAttribute("action");
        });
    });
}
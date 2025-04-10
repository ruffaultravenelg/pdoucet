const delete_btns = document.querySelectorAll('.friend .btn-danger');

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
            if (willDelete) window.location.href = delete_btn.getAttribute("delpath");
        });
    });
}
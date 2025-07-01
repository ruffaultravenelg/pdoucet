const settings_container = document.getElementById('settings_container');

for (const setting of settings_container.children) {

    const update_endpoint = setting.getAttribute('data-update-endpoint');
    const value_label = setting.querySelector('p.setting-value');
    const edit_btn = setting.querySelector('button.edit-btn');

    edit_btn.addEventListener('click', () => {

        let newValue = '';
        swal({
            title: 'Entrez la nouvelle valeur',
            content: "input",
            buttons: true,
        })
        .then(value => {
            newValue = value;
            if (!value) throw null;

            return fetch(update_endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ value }),
            });
        })
        .then(response => {
            if (!response.ok) throw null;
            value_label.textContent = newValue;
            swal("Succès", "Paramètre mis à jour avec succès.", "success");
        })
        .catch(err => {
            if (err) swal("Error!", err, "error");
        });
    });

}

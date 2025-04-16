const form = document.querySelector('#form_container > form');
const form_content = document.getElementById('form_content');
const update_button = document.getElementById('update_button');

// Init TinyMCE
tinymce.init({
    selector: 'main > textarea',
    resize: true,
    menubar: false,
    statusbar: false,
    license_key: 'gpl',
    toolbar: `
        undo redo | bold italic underline strikethrough | 
        alignleft aligncenter alignright alignjustify |
        fontselect fontsizeselect | forecolor backcolor |
        bullist numlist | outdent indent |
        link image | table | 
        removeformat
    `,
    link_default_target: '_blank',
    plugins: [
        'link', 
        'image',
        'table',
    ],
    setup: (editor) => {
        editor.on('init', () => {
            if (form_content.value) {
                editor.setContent(form_content.value);
            }
        });
    }
});

// Submit
update_button.onclick = (e) => {
    e.preventDefault();

    // Get TinyMCE content
    const content = tinymce.activeEditor.getContent();

    // Fill hidden form field
    form_content.value = content;

    // Submit form
    form.submit();

}

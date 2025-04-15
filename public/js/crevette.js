tinymce.init({
    selector: 'textarea.tinymce',
    height: 400,
    menubar: false,
    statusbar: false,
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
});

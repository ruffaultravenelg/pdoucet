// Loads TinyMCE editor
const tinymce_script = document.createElement('script');
tinymce_script.src = '/assets/js/libs/tinymce/tinymce.min.js';

tinymce_script.onload = () => {
    tinymce.init({
      selector: 'textarea.tinymce',
        license_key: 'gpl',

        height: 500,
        menubar: false,

        toolbar_mode: 'sliding',
        toolbar: 'undo redo | ' +
                 'bold italic underline strikethrough blockquote | forecolor | ' +
                 'alignleft aligncenter alignright alignjustify | ' +
                 'bullist numlist | ',
        
        paste_as_text: true,
        default_link_target: '_blank',
        link_title: false,
        branding: false,
        convert_urls: false,
    });
};

document.head.appendChild(tinymce_script);

// Add custom style to hide TinyMCE promotion
const style = document.createElement('style');
style.innerHTML = `
.tox-promotion { display: none !important; }
.tox-tinymce { width: 100% !important; }
`;
document.head.appendChild(style);

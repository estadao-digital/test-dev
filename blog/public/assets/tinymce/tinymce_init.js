var tinymce_config_default = {
    height: 300,
    menubar: false,
    theme: 'modern',
    plugins: "textcolor colorpicker autolink link lists searchreplace hr",
    toolbar: 'undo redo | forecolor fontsizeselect | bold italic removeformat | alignleft aligncenter alignright alignjustify hr | bullist numlist outdent indent | link unlink| searchreplace',
    fontsize_formats: '8px 10px 12px 14px 18px 24px 36px',
    language: 'pt_BR',
    spellchecker_language: 'pt_BR',
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
};

$(function () {
    $("textarea.tinymce").tinymce(tinymce_config_default);
});
$(function () {
    //SHADOWBOX
    //Shadowbox.init();

    //MASCARAS
    $(".formDate").mask("99/99/9999 99:99:99", {placeholder: " "});

    //TinyMCE
    //EXTENSÂO DE YOUTUBE EM \tiny_mce\plugins\media\js MEDIA.js
    /**
     * Editar upload linhas em:
     *      - "external_plugins" em admin.js
     *      - Diretórios em filemanager/config/config.php
     */
    tinymce.init({
        selector: '.js_editor',
        relative_urls: false,
        resize: false,
        remove_script_host: false,
        plugins: 'code paste fullscreen textcolor link image media directionality hr preview print insertdatetime emoticons searchreplace visualblocks table charmap responsivefilemanager',
        menubar: "file edit insert view format table",
        toolbar: 'fullscreen code removeformat | undo redo | styleselect | bold italic underline | forecolor backcolor | bullist numlist | link unlink | outdent indent ltr rtl hr | insertdatetime emoticons responsivefilemanager',
        link_class_list: [
            {title: 'None', value: ''}
        ],
        image_advtab: true,
        image_title: true,
        image_prepend_url: "/",
        insertdatetime_formats: ["%d/%m/%Y %H:%M", "%d/%m/%Y"],
        external_filemanager_path: '../filemanager/',
        filemanager_title: "Browser - Uploads",
        external_plugins: {"filemanager": "../../../filemanager/plugin.min.js"}
    });
});
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="css/reset.css"/>
        <style>
            label{display:block;margin-bottom: 15px; border:1px springgreen solid}
            label span{display:block}
        </style>
    </head>
    <body>
        <?php
        require './_app/config.inc.php';

        $form = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ($form && !empty($form['sendFile'])) {
            $file = $_FILES['file'];
            if ($file['name']) {
                $upload = new Upload;
                $upload->uploadFile($file);
            }
            $media = $_FILES['media'];
            if ($media['name']) {
                $upload = new Upload;
                $upload->uploadMedia($media);

            }
                var_dump($upload);
        }
        ?>
        <form name="fileForm" action="" method="post" enctype="multipart/form-data">
            <label>
                <span>Arquivo:</span>
                <input type="file" name="file"/>
            </label>
            <label>
                <span>Mídia:</span>
                <input type="file" name="media"/>
            </label>
            <input type="submit" name="sendFile" value="Enviar"/>
        </form>
    </body>
</html>

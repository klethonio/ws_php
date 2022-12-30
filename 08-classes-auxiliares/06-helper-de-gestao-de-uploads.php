<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="css/reset.css"/>
    </head>
    <body>
        <?php
        require './_app/config.inc.php';
        
        $form = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if($form && !empty($form['sendImage'])){
            
            $image = $_FILES['image'];
            $upload = new Upload;            
            $upload->uploadImage($image);
            
            if(!$upload->getResult()){
                WSMessage("Erro ao enviar imagem: <small>{$upload->getError()}</small>", WS_ERROR);
            }  else {
                WSMessage("Imagem enviada com sucesso: <small>{$upload->getResult()}</small>", WS_SUCCESS);
            }
            
            echo '<hr/>';
            var_dump($upload);
        }
        ?>
        <form name="fileForm" action="" method="post" enctype="multipart/form-data">
            <label>
                <input type="file" name="image"/>
            </label>
            
            <input type="submit" name="sendImage" value="Enviar"/>
        </form>
    </body>
</html>

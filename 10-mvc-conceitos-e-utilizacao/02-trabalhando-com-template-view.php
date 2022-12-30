<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './_app/config.inc.php';

        $read = new Read;
        $read->exeRead('ws_categories');
        $tpl = file_get_contents('_mvc/category.tpl.html');

        foreach ($read->getResult() as $cat) {
            // extract($cat);
//            echo str_replace(array('#category_title#', '#category_content#'), array($category_title, $category_content), $tpl);
            
            $cat['pubdate'] = date('Y-m-d', strtotime($cat['category_date']));
            $cat['category_date'] = date('d/m/Y H:i', strtotime($cat['category_date']));
             
            $links = preg_replace('/(.+)/', '#$1#', array_keys($cat));
            echo str_replace($links, array_values($cat), $tpl);
        }
        ?>
    </body>
</html>

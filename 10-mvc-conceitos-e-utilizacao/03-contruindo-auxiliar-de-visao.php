<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './_app/config.inc.php';
        new Session;

//        View::load('_mvc/category');
//
//        $read = new Read;
//        $read->exeRead('ws_categories');
//
//        foreach ($read->getResult() as $cat) {
//            $cat['category_content'] = 'Klethonio';
//            View::show($cat);
//        }
//        
//        echo '<h1>Request</h1>';
//        
//        foreach ($read->getResult() as $cat){
//            View::request('_mvc/category', $cat);
//        }
        
        //ws_siteviews_agent
        
        $read = new Read;
        
        $read->exeRead('ws_siteviews_agent');
        
        foreach ($read->getResult() as $browser) {
            $browser['agent_lastview'] = date('d/m/Y H:i', strtotime($browser['agent_lastview']));
            View::load('_mvc/browser', $browser);
        }
        ?>
    </body>
</html>

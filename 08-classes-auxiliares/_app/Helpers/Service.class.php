<?php

/**
 * Description of Check [HELPER]
 * Class responsible for manipulating and validating data.
 * 
 * @author Klethônio Ferreira
 */
class Service
{
    /**
     * Gets the category ID through its name.
     * @param string $category | name column
     * @return int | Category ID
     */
    public static function catIdByName(string $category) {
        $read = new Read(); 
        $read->exeRead('ws_categories', 'WHERE category_name = :name', ['name' => $category]);
        if ($read->count()) {
            return $read->first()['category_id'];
        } else {
            WSMessage("Category {$category} not found!", WS_ERROR, true);
        }
    }
    
    /**
     * Deletes expired users and returns users online.
     * @return int
     */
    public static function onlineUsers() {
        $delOnline = new Delete();
        $delOnline->exeDelete('ws_siteviews_online', 'WHERE online_endview < :now', ['now' => date('Y-m-d H:i:s')]);
        $readOnline = new Read();
        $readOnline->exeRead('ws_siteviews_online');
        return $readOnline->count();
    }
}

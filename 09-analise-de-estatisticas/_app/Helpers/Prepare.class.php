<?php

/**
 * Description of Check [HELPER]
 * Class responsible for manipulating and validating data.
 * 
 * @author Klethônio Ferreira
 */
class Prepare
{
    /**
     * Converts a string into a friendly URL.
     * @param string $string
     * @return string
     */
    public static function slug(string $string): string
    {
        $format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr';
        $format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $string = strtr(utf8_decode($string), utf8_decode($format['a']), $format['b']);
        $string = strtolower(strip_tags(trim($string)));
        $string = preg_replace("/[^a-z0-9_\s\-\.\,\;\:\!\?]/", "", $string);
        $string = preg_replace("/[\s\.\,\;\:\!\?\-]+/", "-", $string);
        return utf8_encode($string);
    }

    /**
     * Convert dates in DD/MM/YYYY to timestamp format.
     * @param string $date | 'd/m/Y' or 'd/m/Y H:i:s'
     * @return string 'Y-m-d H:i:s'
     */
    public static function dateToTimestap(string $date): string
    {
        $format = '/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}(\ [0-9]{2}:[0-9]{2}:[0-9]{2})?$/';
        if (!preg_match($format, $date)) {
            WSMessage('Invalid date format!', WS_ERROR, true);
        } else {
            $date = explode(' ', $date);
            $dataTime = $date[1] ?? date('H:i:s');
            $date = explode('/', $date[0]);

            return $date[2] . '-' . $date[1] . '-' . $date[0] . ' ' . $dataTime;
        }
    }

    /**
     * Limits the number of characters in a string
     * @param string $string
     * @param int $limit
     * @param string $strEnd | Displayed at end of string: '...', 'read more...'
     * @return string
     */
    public static function shortenString(string $string, int $limit, string $strEnd = '...'): string
    {
        $string = strip_tags(trim($string));
        if (mb_strlen($string, 'utf-8') <= $limit) {
            return $string;
        } else {
            $strrpos = mb_strrpos(mb_substr($string, 0, $limit, 'utf-8'), ' ', 0, 'utf-8');
            return mb_substr($string, 0, $strrpos, 'utf-8') . $strEnd;
        }
    }

    /**
     * Checks for the existence of an image in the uploads folder and returns it resized.
     * @param string $name
     * @param string $description
     * @param int $width
     * @param int $height
     * @return string = '<img src="$name" alt="$description" title="$description"/>'
     */
    public static function getImage(string $name, string $description, $width = 0, $height = 0): string
    {
        $image = 'uploads/'.$name;
        $width = (int) $width;
        $height = (int) $height;
        if(is_file($image)){
            $path = defined('HOME') ? constant('HOME') : '.';
            return "<img src=\"{$path}/tim.php?src={$path}/{$image}&w={$width}&h={$height}\" alt=\"{$description}\" title=\"{$description}\"/>";
        }
    }
}

<?php

/**
 * Drescription of View
 * Responsible for loading the template, populating and displaying the view, populating and including PHP files in the system.
 * MVC architecture
 * @author Klethônio Ferreira
 */
class View
{
    private static $data;
    private static $keys;
    private static $values;
    private static $template;
     
    public static function load(string $template, array $data): void
    {
        self::$template = file_get_contents($template . '.tpl.html');
        self::$data = $data;
        self::setKeys();
        self::setValues();
        self::show();
    }
     
    public static function request($file, array $data): void
    {
        extract($data);
        require "{$file}.inc.php";
    }
     
     //PRIVATE
    private static function show(): void
    {
        echo str_replace(self::$keys, self::$values, self::$template);
    }

    private static function setKeys(): void
    {
        self::$keys = preg_replace('/(.+)/', '#$1#', array_keys(self::$data));
    }
     
    private static function setValues(): void
    {
        self::$values = array_values(self::$data);
    }
}

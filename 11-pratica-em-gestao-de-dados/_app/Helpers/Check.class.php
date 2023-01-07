<?php

/**
 * Description of Check [HELPER]
 * Class responsible for manipulating and validating data.
 * 
 * @author Klethônio Ferreira
 */
class Check
{
    /**
     * Perform email validation.
     * @param string $email
     * @return boolean
     */
    public static function email(string $email): bool
    {
        return preg_match('/^[^0-9.\-][a-z0-9_\.\-]+@[a-z0-9]+[a-z0-9_\.\-]*[.][a-z]{2,4}$/', $email) ? true : false;
    }
}

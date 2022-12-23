<?php

/**
 * <b>Descrição de AssociationLogin</b>
 *
 * @author Klethônio Ferreira
 */
class AssociationLogin {

    /** @var AssociationClient  */
    private $client;
    private $login;

    public function __construct(AssociationClient $client) {
        $this->client = $client;
        $this->login = TRUE;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getClient() {
        return $this->client;
    }

}

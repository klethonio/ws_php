<?php

/**
 * Description of Login
 * Responsible for authenticating, validating and reaching system users
 * @author Klethônio Ferreira
 */
class Login
{

    private $level;
    private $email;
    private $password;
    private $error;
    private $result;

    /**
     * Enter the minimum access level for the area to be protected.
     * @param int $level | Access level
     */
    function __construct($level)
    {
        $this->level = (int) $level;
    }

    /**
     * Attach an attributive array with indexes string user [email], string password.
     * @param array $userData
     */
    public function exeLogin(array $userData): void
    {
        $this->email = (string) strip_tags(trim($userData['user']));
        $this->password = (string) strip_tags(trim($userData['password']));
        $this->password = Prepare::encStr($this->password);
        $this->setLogin();
    }

    /**
     * By executing a getResult it is possible to verify whether or not the data was accessed.
     * @return bool
     */
    function getResult(): null|array
    {
        return $this->result;
    }

    /**
     * Returns an associative array with a message and an error type of WS_.
     * @return array
     */
    function getError(): null|array
    {
        return $this->error;
    }

    /**
     * Run this method to verify the userLogin session and revalidate access to secure restricted screens.
     * @return bool
     */
    public function checkLogin(): bool
    {
        if (empty($_SESSION['userLogin']) || $_SESSION['userLogin']['user_level'] < $this->level) {
            unset($_SESSION['userLogin']);

            return false;
        } else {
            $userLogin = $this->getUser($_SESSION['userLogin']['user_email'], $_SESSION['userLogin']['user_password']);

            return ($userLogin && $this->result['user_level'] == $_SESSION['userLogin']['user_level']) ? true : false;
        }
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Validates data and stores errors if any.
    private function setLogin(): void
    {
        if (!$this->email || !$this->password) {
            $this->error = ['Informe seu e-mail e senha para efetuar o login.', WS_INFOR];
        } elseif (!Check::email($this->email)) {
            $this->error = ['E-mail informado inválido!', WS_INFOR];
        } elseif (!$this->getUser($this->email, $this->password)) {
            $this->error = ['E-mail ou senha incorretos!', WS_ALERT];
        } elseif ($this->result['user_level'] < $this->level) {
            $this->error = ["Desculpe, {$this->result['user_name']}, você não tem permissão para acessar esta área!", WS_ALERT];
        } else {
            $this->execute();
            return;
        }
        $this->result = null;
    }

    //Verifies user and password in the database.
    private function getUser($email, $password): bool
    {
        $read = new Read();
        $read->exeRead('ws_users', 'WHERE user_email = :e AND user_password = :p', ['e' => $email, 'p' => $password]);
        if ($read->getResult()) {
            $this->result = $read->first();
            return true;
        } else {
            return false;
        }
    }

    //Performs the login storing the session.
    private function execute(): void
    {
        if (!session_id()) {
            session_start();
        }

        $_SESSION['userLogin'] = $this->result;
        $this->error = null;
        $this->result = ["Olá {$this->result['user_name']}, seja bem vindo(a). Aguarde redirecionamento!", WS_SUCCESS];
    }

}

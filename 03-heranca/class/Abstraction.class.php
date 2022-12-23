<?php

/**
 * <b>Descrição de Abstraction</b>
 *
 * @author Klethônio Ferreira
 */
abstract class Abstraction {

    public $client;
    public $account;
    public $balance;

    public function __construct($client, $balance) {
        $this->client = $client;
        $this->balance = $balance;
    }

    public function extract() {
        echo "<hr/>Olá {$this->client}. Seu saldo em {$this->account} é de {$this->balance}.<hr/>";
    }

    public function deposit($value) {
        $this->balance += $value;
        echo "<span style='color: green;'><b>{$this->account}:</b> Depósito de {$this->toReal($value)} efetuado com sucesso.</span><hr/>";
    }

    public function withdraw($value) {
        $this->balance -= $value;
        echo "<span style='color: red;'><b>{$this->account}:</b> Saque de {$this->toReal($value)} efetuado com sucesso.</span><hr/>";
    }

    public function transfer(float $value, Abstraction $to) {
        if ($this === $to) {
            echo 'Você não pode transferir valores para mesma conta.<hr/>';
        } else {
            $this->withdraw($value);
            $to->deposit($value);
            echo "<span style='color: blue;'><b>{$this->account}:</b> Transferência de {$this->toReal($value)} para {$to->client} efetuado com sucesso.</span><hr/>";
        }
    }
    
    abstract public function balanceInfo();

    public function toReal($value) {
        return "R$ " . number_format($value, 2, ',', '.');
    }

}

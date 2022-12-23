<?php

/**
 * <b>Descrição de AbstractionCC</b>
 *
 * @author Klethônio Ferreira
 */
class AbstractionCA extends Abstraction {

    public $limit;

    public function __construct($client, $balance, $limit) {
        parent::__construct($client, $balance);
        $this->account = 'Conta Corrente';
        $this->limit = $limit;
    }

    final public function withdraw($value) {
        if ($this->balance + $this->limit >= (float) $value) {
            parent::withdraw($value);
        } else {
            echo "<span style='color: red;'><b>{$this->account}:</b> Erro ao sacar {$this->toReal($value)}, Saldo indisponível.</span><hr/>";
        }
    }

    /** @param Abstraction $to */
    final public function transfer($value, $to) {
        if ($this->balance + $this->limit >= (float) $value) {
            parent::transfer($value, $to);
        } else {
            echo "<span style='color: red;'><b>{$this->account}:</b> Erro ao transferir {$this->toReal($value)}, Saldo indisponível.</span><hr/>";
        }
    }

    public function balanceInfo() {
        parent::extract();
    }

}

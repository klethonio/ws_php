<?php

/**
 * <b>Descrição de AbstractionSA</b>
 *
 * @author Klethônio Ferreira
 */
class AbstractionSA extends AbstractionCA {

    public $incomePercent;

    public function __construct($client, $balance) {
        parent::__construct($client, $balance, 0);
        $this->account = 'Conta Poupança';
        $this->incomePercent = 0.017;
    }

    final public function setIncomePercent($incomePercent) {
        $this->incomePercent = $incomePercent;
    }

    final public function deposit($value) {
        $income = $value * $this->incomePercent;
        $total = $value + $income;
        parent::deposit($total);
        echo "<small style='color: #09f'>Valor do depósito: {$this->toReal($value)} || Redimento: {$this->toReal($income)}</small><hr/>";
    }

}

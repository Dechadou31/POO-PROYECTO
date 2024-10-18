<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:30 AM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class DepositTransaction implements BankTransactionInterface
{
    private $amount;

    /**
     * Constructor que establece el monto del depósito.
     *
     * @param float $amount
     */
    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    /**
     * Aplica la transacción de depósito a la cuenta bancaria.
     *
     * @param BankAccountInterface $account
     * @return float El nuevo saldo de la cuenta.
     */
    public function applyTransaction(BankAccountInterface $account)
    {
        // Obtener el saldo actual
        $currentBalance = $account->getBalance();

        // Sumar el monto del depósito al saldo actual
        $newBalance = $currentBalance + $this->amount;

        // Establecer el nuevo saldo en la cuenta
        $account->setBalance($newBalance);

        // Devolver el nuevo saldo
        return $newBalance;
    }

    /**
     * Devuelve la información de la transacción de depósito.
     *
     * @return string
     */
    public function getTransactionInfo()
    {
        return "Depósito de: $" . number_format($this->amount, 2);
    }

    /**
     * Devuelve el monto del depósito.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

   
}

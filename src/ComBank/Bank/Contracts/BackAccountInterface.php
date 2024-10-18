<?php namespace ComBank\Bank\Contracts;

/**
 * Creado por VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:26 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;

interface BankAccountInterface
{
    const STATUS_OPEN = 'OPEN';
    const STATUS_CLOSED = 'CLOSED';

    /**
     * Procesar una transacción en la cuenta bancaria.
     *
     * @param BankTransactionInterface $transaction
     * @throws FailedTransactionException
     */
    public function transaction(BankTransactionInterface $transaction);

    /**
     * Abrir la cuenta bancaria.
     *
     * @return bool Indica si la cuenta se abrió correctamente.
     */
    public function openAccount();

    /**
     * Reabrir una cuenta bancaria que fue cerrada.
     *
     * @throws BankAccountException
     */
    public function reopenAccount();

    /**
     * Cerrar la cuenta bancaria.
     *
     * @throws BankAccountException
     */
    public function closeAccount();

    /**
     * Obtener el saldo actual de la cuenta bancaria.
     *
     * @return float El saldo actual de la cuenta.
     */
    public function getBalance();

    /**
     * Obtener el sobregiro asociado a la cuenta bancaria.
     *
     * @return OverdraftInterface
     */
    public function getOverdraft();

    /**
     * Aplicar una estrategia de sobregiro a la cuenta bancaria.
     *
     * @param OverdraftInterface $overdraft
     */
    public function applyOverdraft(OverdraftInterface $overdraft);

    /**
     * Establecer el saldo de la cuenta bancaria.
     *
     * @param float $balance El nuevo saldo de la cuenta.
     */
    public function setBalance($balance);
}

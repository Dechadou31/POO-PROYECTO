<?php namespace ComBank\Bank;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:25 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;


class BankAccount implements BackAccountInterface {
    private $balance;
    private $status;
    private $overdraft;

    public function __construct($initialBalance = 0.0, OverdraftInterface $overdraft = null) {
        $this->balance = $initialBalance;
        $this->status = true;  // Account is open by default
        $this->overdraft = $overdraft;
    }
    
    public function transaction(BankTransactionInterface $transaction): void {
        $transaction->processTransaction();
    }

    public function openAccount(): bool {
        if (!$this->status) {
            $this->status = true;
            return true;  // Account reopened successfully
        }
        return false;  // Account is already open
    }

        // Reopen a closed account
        public function reopenAccount(): void {
            $this->status = true;
        }
    
        // Close the account
        public function closeAccount(): void {
            $this->status = false;
        }
    
        // Get the current balance
        public function getBalance(): float {
            return $this->balance;
        }
    
        // Get overdraft details (assuming the overdraft logic is implemented in the interface)
        public function getOverdraft(): getOverdraftInterface {
            return $this->overdraft;
        }
    
        // Apply an overdraft limit to the account
        public function applyOverdraft(OverdraftInterface $overdraft): void {
            $this->overdraft = $overdraft;
        }
    
        // Set the balance of the account
        public function setBalance($amount): void {
            $this->balance = $amount;
        }
}

    

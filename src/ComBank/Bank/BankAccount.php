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

    public function __construct($initialBalance = 0.0) {
        $this->balance = $initialBalance;
        $this->status = BackAccountInterface::STATUS_OPEN;  // Account is open by default
        $this->overdraft = new NoOverdraft();
    }
    public function transaction(BankTransactionInterface $transaction): void {
        if ($this->status === BackAccountInterface::STATUS_OPEN) {  
            try {
                $this->balance = $transaction->applyTransaction($this);
            }catch (InvalidOverdraftFundsException $e) {
                throw new FailedTransactionException($e->getMessage());
            }
        }else{
            throw new BankAccountException("Closed account");
        }
       

    }

    public function openAccount(): bool {
        if ($this->status === BackAccountInterface::STATUS_OPEN) {
            $this->status = BackAccountInterface::STATUS_OPEN;
            return true;  // Account reopened successfully
        }
        return false;  // Account is already open
    }

        // Reopen a closed account
        public function reopenAccount(): void {
            if ($this->openAccount()) {
                throw new BankAccountException("The account is already open. You cannot reope ");
            }else{
            $this->status = BackAccountInterface::STATUS_OPEN;
        }
    }
    
        // Close the account
        public function closeAccount(): void {
            if(!$this->openAccount()){
                throw new BankAccountException("Error: Account is already closed.");
            }else{
            $this->status = BackAccountInterface::STATUS_CLOSED;
        }
    }
    
        // Get the current balance
        public function getBalance(): float {
            return $this->balance;
        }
    
        // Get overdraft details (assuming the overdraft logic is implemented in the interface)
        public function getOverdraft(): OverdraftInterface {
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

    

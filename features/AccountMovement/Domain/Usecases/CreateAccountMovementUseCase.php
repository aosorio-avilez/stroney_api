<?php

namespace Features\AccountMovement\Domain\Usecases;

use App\Models\Account;
use App\Models\AccountMovement;
use Features\Account\Domain\Repositories\AccountRepository;
use Features\AccountMovement\Data\Models\MovementType;
use Features\AccountMovement\Domain\Repositories\AccountMovementRepository;
use Illuminate\Support\Facades\DB;

class CreateAccountMovementUseCase
{
    private AccountMovementRepository $repository;
    private AccountRepository $accountRepository;

    public function __construct(
        AccountMovementRepository $repository,
        AccountRepository $accountRepository
    ) {
        $this->repository = $repository;
        $this->accountRepository = $accountRepository;
    }

    public function handle(
        AccountMovement $accountMovement,
        bool $isTransfer
    ): AccountMovement {
        DB::beginTransaction();

        $movement = null;

        if ($isTransfer) {
            $account = $this->accountRepository->getById($accountMovement->account_id);
            $accountMovement->movement_type = MovementType::expense()->value;

            $movement = $this->makeExpense($account, $accountMovement);

            $destinationAccount = $this->accountRepository->getById($accountMovement->destination_account_id);
            
            $incomeMovement = $accountMovement->replicate();
            $incomeMovement->movement_type = MovementType::income();
            $incomeMovement->account_id = $accountMovement->destination_account_id;
            $incomeMovement->destination_account_id = $accountMovement->account_id;
            $incomeMovement->amount = ($incomeMovement->amount / $account->userCurrency->exchange_rate) * $destinationAccount->userCurrency->exchange_rate;

            $this->makeIncome($destinationAccount, $incomeMovement);
        } else {
            $account = $this->accountRepository->getById($accountMovement->account_id);

            if ($accountMovement->movement_type == MovementType::income()->value) {
                $movement = $this->makeIncome($account, $accountMovement);
            } else {
                $movement = $this->makeExpense($account, $accountMovement);
            }
        }

        DB::commit();

        return $movement;
    }

    private function makeExpense(Account $account, AccountMovement $accountMovement): AccountMovement
    {
        $account->amount = $account->amount - $accountMovement->amount;
    
        $this->updateAccount($account);
        
        return $this->createMovement($accountMovement);
    }

    private function makeIncome(Account $account, AccountMovement $accountMovement): AccountMovement
    {
        $account->amount = $account->amount + $accountMovement->amount;

        $this->updateAccount($account);
        
        return $this->createMovement($accountMovement);
    }

    private function updateAccount(Account $account): Account
    {
        return $this->accountRepository->update($account->id, $account);
    }

    private function createMovement(AccountMovement $accountMovement): AccountMovement
    {
        return $this->repository->create($accountMovement);
    }
}

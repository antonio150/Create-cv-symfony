<?php

namespace App\Services;

class helper
{
    public function __construct()
    {
    }

    public function _is_correct_password($password)
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);

        if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            return false;
        }
        return true;
    }

    public function feeMvola($amount): ?int
    {
        $fee = 0;
        switch ($amount) {
            case ($amount < 100) && ($amount <= 1000):
                $fee = 50;
                break;

            case ($amount < 1001) && ($amount <= 5000):
                $fee = 50;
                break;

            case ($amount < 5001) && ($amount <= 10000):
                $fee = 100;
                break;

            case ($amount < 10001) && ($amount <= 25000):
                $fee = 200;
                break;

            case ($amount < 25001) && ($amount <= 50000):
                $fee = 400;
                break;

            case ($amount < 50001) && ($amount <= 100000):
                $fee = 800;
                break;

            case ($amount < 100001) && ($amount <= 250000):
                $fee = 1500;
                break;

            case ($amount < 250001) && ($amount <= 500000):
                $fee = 1500;
                break;

            case ($amount < 500001) && ($amount <= 1000000):
                $fee = 2500;
                break;

            case ($amount > 1000001):
                $fee = 3000;
                break;
        }

        return $fee;
    }

    public function feeAirtelMoney($amount): ?int
    {
        $fee = 0;
        switch ($amount) {
            case ($amount < 300) && ($amount <= 1000):
                $fee = 50;
                break;

            case ($amount < 1001) && ($amount <= 5000):
                $fee = 50;
                break;

            case ($amount < 5001) && ($amount <= 10000):
                $fee = 100;
                break;

            case ($amount < 10001) && ($amount <= 20000):
                $fee = 200;
                break;

            case ($amount < 20001) && ($amount <= 25000):
                $fee = 300;
                break;

            case ($amount < 25001) && ($amount <= 30000):
                $fee = 300;
                break;

            case ($amount < 30001) && ($amount <= 40000):
                $fee = 400;
                break;

            case ($amount < 40001) && ($amount <= 50000):
                $fee = 600;
                break;

            case ($amount < 50001) && ($amount <= 60000):
                $fee = 600;
                break;

            case ($amount < 60001) && ($amount <= 80000):
                $fee = 800;
                break;

            case ($amount < 80001) && ($amount <= 100000):
                $fee = 800;
                break;

            case ($amount < 100001) && ($amount <= 150000):
                $fee = 1500;
                break;

            case ($amount < 150001) && ($amount <= 250000):
                $fee = 1500;
                break;

            case ($amount < 250001) && ($amount <= 500000):
                $fee = 1500;
                break;

            case ($amount < 500001) && ($amount <= 1000000):
                $fee = 2500;
                break;

            case ($amount > 1000001):
                $fee = 3000;
                break;
        }

        return $fee;
    }

    public function getWithdrawalFee($method, $amount): ?int
    {
        $fee = 0;
        switch ($method) {
            case "mvola":
                $fee = $this->feeMvola($amount);
                break;
            case "airtelMoney":
                $fee = $this->feeAirtelMoney($amount);
                break;
        }
        return $fee;
    }
}

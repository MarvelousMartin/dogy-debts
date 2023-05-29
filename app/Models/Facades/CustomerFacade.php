<?php

namespace App\Models\Facades;

use Illuminate\Support\Facades\DB;

class CustomerFacade
{
    public function getTotalDebt(): int
    {
        return DB::select('SELECT SUM(price) AS debt FROM debt')[0]->debt;
    }
    public function getCustomerDebts(?string $orderBy = 'ASC'): array
    {
        return DB::select('SELECT c.id AS id, c.name AS name, COALESCE(SUM(d.price), 0) AS debt FROM customers c LEFT JOIN debt d ON c.id = d.owner GROUP BY c.id, c.name ORDER BY MAX(COALESCE(d.price, 0))'.$orderBy);
    }

    public function getCustomerDebtsByName(): array
    {
        return DB::select('SELECT c.id AS id, c.name AS name, COALESCE(SUM(d.price), 0) AS debt FROM customers c LEFT JOIN debt d ON c.id = d.owner GROUP BY c.id, c.name ORDER BY c.name;');
    }

    public function getCustomerTotalDebt(int $id): array
    {
        return DB::select('SELECT SUM(price) AS debt FROM debt WHERE id = '.$id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Facades\CustomerFacade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CustomersController extends Controller
{
    public function __construct(
        private readonly CustomerFacade $customerFacade,
    ) {
    }

    public function index(Request $request): View
    {
        if ($request->has('sort')) {
            $sort = match ($request->get('sort')) {
                'name' => $this->customerFacade->getCustomerDebtsByName(),
                'debta' => $this->customerFacade->getCustomerDebts(),
                'debtd' => $this->customerFacade->getCustomerDebts('DESC'),
            };

            return view('index', [
                'customers' => $sort,
                'request' => $request->get('sort'),
                'total' => $this->customerFacade->getTotalDebt(),
            ]);
        } else {
            return view('index', [
                'customers' => $this->customerFacade->getCustomerDebtsByName(),
                'request' => 'name',
                'total' => $this->customerFacade->getTotalDebt(),
            ]);
        }
    }

    public function newDebtor(Request $request): RedirectResponse
    {
        $debtor = $request->get('debtor');
        DB::insert('INSERT INTO customers (name) VALUES (?)', [$debtor]);

        return to_route('homepage')->with('success', 'Účet založený!');
    }
}

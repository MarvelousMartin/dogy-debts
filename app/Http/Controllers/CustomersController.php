<?php

namespace App\Http\Controllers;

use App\Models\Facades\CustomerFacade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CustomersController extends Controller
{
    private CustomerFacade $customerFacade;

    public function __construct(
        CustomerFacade $customerFacade
    ) {
        $this->customerFacade = $customerFacade;
    }

    public function index(Request $request): View
    {
        if ($request->has('sort')) {
            $sort = $request->get('sort');
            switch ($sort) {
                case 'name':
                    $sortResult = $this->customerFacade->getCustomerDebtsByName();
                    break;
                case 'debta':
                    $sortResult = $this->customerFacade->getCustomerDebts();
                    break;
                case 'debtd':
                    $sortResult = $this->customerFacade->getCustomerDebts('DESC');
                    break;
                default:
                    $sortResult = null;
                    break;
            }


            return view('index', [
                'customers' => $sortResult,
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

        return redirect()->route('homepage')->with('success', 'Účet založený!');
    }
}

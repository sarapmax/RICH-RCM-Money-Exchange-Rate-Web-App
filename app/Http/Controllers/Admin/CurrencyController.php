<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CurrencyRequest;
use App\Repos\CurrencyRepo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    /**
     * @var CurrencyRepo
     */
    protected $currencyRepo;

    /**
     * CurrencyController constructor.
     *
     * @param CurrencyRepo $currencyRepo
     */
    public function __construct(CurrencyRepo $currencyRepo) {
        $this->currencyRepo = $currencyRepo;
    }

    /**
     * Add currency and banknotes.
     *
     * @param CurrencyRequest $request
     * @return mixed
     */
    public function addCurrency(CurrencyRequest $request) {
        return $this->currencyRepo->insertCurrecyAndBanknotes($request->all());
    }

    /**
     * @param $id
     * @return Collection|static[]
     */
    public function getCurrencyById($id) {
        return $this->currencyRepo->getCurrencyById($id);
    }

    /**
     * @param $id
     * @param CurrencyRequest $request
     * @return mixed
     */
    public function updateCurrency($id, CurrencyRequest $request) {
        return $this->currencyRepo->updateCurrencyAndUpdateOrCreateBanknotes($id, $request->all());
    }

    public function deleteCurrency($id) {
        return $this->currencyRepo->deleteCurrencyAndBanknotes($id);
    }
}

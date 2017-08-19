<?php

namespace App\Http\Controllers\Page;

use App\Repos\BanknoteRepo;
use App\Repos\CurrencyRepo;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * @var CurrencyRepo
     */
    protected $currencyRepo;

    /**
     * @var BanknoteRepo
     */
    protected $banknoteRepo;

    /**
     * @var Carbon
     */
    protected $carbon;

    /**
     * HomeController constructor.
     *
     * @param CurrencyRepo $currencyRepo
     * @param BanknoteRepo $banknoteRepo
     * @param Carbon $carbon
     */
    public function __construct(
        CurrencyRepo $currencyRepo,
        BanknoteRepo $banknoteRepo,
        Carbon $carbon
    ) {
        $this->currencyRepo = $currencyRepo;
        $this->banknoteRepo = $banknoteRepo;
        $this->carbon = $carbon;
    }

    /**
     * Show home page.
     *
     * @return Factory|View
     */
    public function showHomePage()
    {
        return view('pages.home');
    }


    /**
     * Get currency with banknotes.
     *
     * @return Collection|static[]
     */
    public function getCurrencyWithBanknotes() {
        return $this->currencyRepo->getCurrencyWithBanknotes();
    }

    public function getCurrencyLastUpdated() {
        $currency = $this->banknoteRepo->getLastUpdated();

        $this->carbon->parse($currency->updated_at)->format('d-m-Y');

        return $currency;
    }
}

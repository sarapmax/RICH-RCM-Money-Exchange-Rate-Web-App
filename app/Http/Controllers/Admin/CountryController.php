<?php

namespace App\Http\Controllers\Admin;

use App\Repos\CountryRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    /**
     * @var CountryRepo
     */
    protected $countryRepo;

    /**
     * CountryController constructor.
     *
     * @param CountryRepo $countryRepo
     */
    public function __construct(CountryRepo $countryRepo) {
        $this->countryRepo = $countryRepo;
    }

    /**
     * Get all countries.
     *
     * @return mixed
     */
    public function getAllCountries() {
        return $this->countryRepo->all();
    }
}

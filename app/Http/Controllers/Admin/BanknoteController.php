<?php

namespace App\Http\Controllers\Admin;

use App\Repos\BanknoteRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

class BanknoteController extends Controller
{
    /**
     * @var BanknoteRepo
     */
    protected $banknoteRepo;

    /**
     * BanknoteController constructor.
     * @param BanknoteRepo $banknoteRepo
     */
    public function __construct(BanknoteRepo $banknoteRepo) {
        $this->banknoteRepo = $banknoteRepo;
    }

    /**
     * @param $id
     * @return bool|null
     */
    public function deleteBanknote($id) {
        $this->banknoteRepo->deleteBaknote($id);
    }
}

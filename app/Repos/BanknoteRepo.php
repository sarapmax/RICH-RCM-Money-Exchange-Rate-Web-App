<?php

namespace App\Repos;

use App\Events\CurrencyEvent;
use App\Models\Banknote;
use Illuminate\Support\Collection;

class BanknoteRepo
{
    /**
     * @var Banknote
     */
    protected $banknote;

    /**
     * BanknoteRepo constructor.
     *
     * @param Banknote $banknote
     */
    public function __construct(Banknote $banknote) {
        $this->banknote = $banknote;
    }

    /**
     * @param $id
     * @return bool|null
     */
    public function deleteBaknote($id) {
        event(new CurrencyEvent('Currency or banknotes changed'));

        return $this->banknote->find($id)->delete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getLastUpdated() {
        return $this->banknote->orderBy('updated_at', 'DESC')->first();
    }
}

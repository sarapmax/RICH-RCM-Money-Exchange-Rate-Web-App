<?php

namespace App\Repos;

use App\Events\CurrencyEvent;
use App\Models\Banknote;
use App\Models\Currency;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;

class CurrencyRepo
{
    /**
     * @var Currency
     */
    protected $currency;

    /**
     * @var Banknote
     */
    protected $banknote;

    /**
     * @var db
     */
    protected $db;

    /**
     * CurrencyRepo constructor.
     *
     * @param Currency $currency
     * @param Banknote $banknote
     * @param DatabaseManager $db
     */
    public function __construct(Currency $currency, Banknote $banknote, DatabaseManager $db) {
        $this->currency = $currency;
        $this->banknote = $banknote;
        $this->db = $db;
    }

    /**
     * Get currency with banknotes.
     *
     * @return Collection|static[]
     */
    public function getCurrencyWithBanknotes() {
        return $this->currency->with(['banknotes', 'country'])->get();
    }

    /**
     * Insert currency and banknotes.
     *
     * @param $params
     * @return mixed
     */
    public function insertCurrecyAndBanknotes($params) {
        $transaction = $this->db->transaction(function() use($params) {
            $currency = $this->currency->create([
                'country_id' => $params['country_id'],
                'name' => $params['name'],
                'unit' => $params['unit'],
            ]);

            if(!empty($params['banknotes'])) {
                foreach($params['banknotes'] as $banknote) {
                    $this->banknote->create([
                        'currency_id' => $currency->id,
                        'name' => $banknote['name'],
                        'buying' => $banknote['buying'],
                        'selling' => $banknote['selling'],
                    ]);
                }
            }

            event(new CurrencyEvent('Currency or banknotes changed !'));
        });

        return $transaction;
    }

    /**
     * Get currency with banknotes by currenct id.
     *
     * @param $id
     * @return Collection|static[]
     */
    public function getCurrencyById($id) {
        return $this->currency->with('banknotes')->find($id);
    }

    /**
     * Update currency and update or create banknotes.
     *
     * @param $id
     * @param $params
     * @return mixed
     */
    public function updateCurrencyAndUpdateOrCreateBanknotes($id, $params) {
        $transaction = $this->db->transaction(function() use($id, $params) {
            $currency = $this->currency->find($id);

            $currency->country_id = $params['country_id'];
            $currency->name = $params['name'];
            $currency->unit = $params['unit'];

            $currency->save();

            foreach ($params['banknotes'] as $banknote) {
                $banknote_id = $banknote['id'] ?? null;

                $currency->banknotes()->updateOrCreate(['id' => $banknote_id], [
                    'currency_id' => $currency->id,
                    'name' => $banknote['name'],
                    'buying' => $banknote['buying'],
                    'selling' => $banknote['selling'],
                ]);
            }

            event(new CurrencyEvent('Currency or banknotes changed !'));
        });

        return $transaction;
    }

    /**
     * Delete currency and all banknotes.
     *
     * @param $id
     * @return mixed
     */
    public function deleteCurrencyAndBanknotes($id) {
        $transaction = $this->db->transaction(function() use($id) {
            $currency = $this->currency->find($id);

            foreach($currency->banknotes as $banknote) {
                $banknote->delete();
            }

            $currency->delete();

            event(new CurrencyEvent('Currency or banknotes changed !'));
        });

        return $transaction;
    }
}

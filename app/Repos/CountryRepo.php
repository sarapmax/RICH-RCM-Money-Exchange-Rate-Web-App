<?php

namespace App\Repos;

use App\Models\Country;
use Illuminate\Cache\Repository as Cache;

class CountryRepo
{
    /**
     * @var Country
     */
    protected $country;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * CountryRepo constructor.
     *
     * @param Cache $cache
     * @param Country $country
     */
    public function __construct(Country $country, Cache $cache) {
        $this->country = $country;
        $this->cache = $cache;
    }

    public function all() {
        return $this->cache->remember('country-all', 60, function() {
            return $this->country->all();
        });
    }
}

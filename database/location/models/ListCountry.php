<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryLookup extends Model
{
    public function getStates()
    {
        return $this->hasOne(ListState::class, 'list_country_id', 'id');
    }
}

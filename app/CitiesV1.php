<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CitiesV1 extends Model
{
    protected $fillable = [
        'geo_name_id',
        'name',
        'ascii_name',
        'alternate_names',
        'latitude',
        'longitude',
        'feature_class',
        'country_code',
        'cc2',
        'admin1',
        'admin2',
        'admin3',
        'admin4',
        'population',
        'elevation',
        'dem',
        'timezone',
        'modification_date',
    ];
}

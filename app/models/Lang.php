<?php

class Lang extends Model
{
    protected $table = 'lang';

    protected $allowedColumns = [
        "id",
        "key",
        "countryCode",
        "country",
    ];
}
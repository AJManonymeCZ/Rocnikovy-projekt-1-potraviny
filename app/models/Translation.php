<?php

class Translation extends Model
{
    public $table = "translation";

    protected $allowedColumns = [
        "id",
        "key",
        "translation",
    ];
}
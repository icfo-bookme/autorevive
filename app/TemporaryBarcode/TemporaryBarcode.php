<?php

namespace App\TemporaryBarcode;

use Illuminate\Database\Eloquent\Model;

class TemporaryBarcode extends Model
{
    const USED_BARCODE = 1;
    const NOT_USED_BARCODE = 0;

    protected $table = 'temporary_barcodes';

    protected $fillable = [
        'category_id',
        'barcode',
        'status'
    ];
}

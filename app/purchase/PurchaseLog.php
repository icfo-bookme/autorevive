<?php

namespace App\purchase;

use Illuminate\Database\Eloquent\Model;

use App\vendor\VendorModel;

class PurchaseLog extends Model
{
    protected $table = 'purchase_logs';

    protected $fillable = [
        'purchase_id',
        'vendor_id',
        'invoice_number',
        'purchase_date',
        'total_amount',
        'paid_amount',
        'due_amount',
        'remarks',
        'is_draft',
        'completed_at',
        'created_by',
        'updated_by',
        'challan_img',
        'soft_delete'
    ];

    public function vendor()
    {
        return $this->belongsTo(VendorModel::class, 'vendor_id', 'id');
    }
    
}

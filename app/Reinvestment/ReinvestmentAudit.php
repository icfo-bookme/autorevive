<?php

namespace App\Reinvestment;

use Illuminate\Database\Eloquent\Model;
use App\Reinvestment\Reinvestment;

class ReinvestmentAudit extends Model
{
    protected $table = 'reinvestment_audits';
    protected $fillable = [
        'trigger_type',
        'reinvestment_id',
        'amount',
        'date',
        'description',
        'created_by',
        'updated_by',
        'soft_delete',
    ];

    public function fund(){
        return $this->belongsTo(Reinvestment::class,'reinvestment_id','id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    }
}

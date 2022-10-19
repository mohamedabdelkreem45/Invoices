<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'invoice_number',
        'product',
        'section_id',
        'note',
        'status',
        'value_status',
        'payment_date',
        'user'
    ];

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
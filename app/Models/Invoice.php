<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'invoice_number',
        'invoice_Date',
        'due_date',
        'product',
        'section_id',
        'discount',
        'amount_collection',
        'amount_commission',
        'rate_vat',
        'value_vat',
        'total',
        'note',
    ];

    protected $dates = ['deleted_at'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function invoice_details()
    {
        return $this->belongsTo(Invoice_detail::class);
    }

    public function invoice_attachments()
    {
        return $this->belongsTo(invoice_attachment::class);
    }
}
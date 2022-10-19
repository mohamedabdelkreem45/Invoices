<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_attachment extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'file_name',
        'invoice_number',
        'created_by'
    ];
}
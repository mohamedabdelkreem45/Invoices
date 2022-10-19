<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_name',
        'description',
        'createdBy'
    ];

    public function invoices()
    {
        return $this->belongsTo(Invoice::class,);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
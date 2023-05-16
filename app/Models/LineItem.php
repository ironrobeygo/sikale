<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quote;

class LineItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'quantity',
        'price',
        'discount',
        'vat',
        'amount'
    ];

    protected $table = 'line_item_quotes';

    public function quote(){
        return $this->belongsTo(Quote::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quote;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customers";

    protected $fillable = [
        'name', 
        'email',
        'phone',
        'tax_number',
        'address',
        'city',
        'postal'
    ]; 

    public function quotes(){
        return $this->hasMany(Quote::class);
    }
}

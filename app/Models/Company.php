<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Company extends Model
{

    protected $fillable = ['company_name', 'street_address', 'representative_name'];


    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

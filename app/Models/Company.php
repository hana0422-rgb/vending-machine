<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Company extends Model
{
    // 一括代入を許可する属性
    protected $fillable = ['company_name', 'street_address', 'representative_name'];

    // Product モデルとのリレーションを定義
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

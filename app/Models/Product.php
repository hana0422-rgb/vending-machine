<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'maker_name',
        'price',
        'stock',
        'comment',
        'company_id',
        'image_path',
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // 売上を複数持つ（子）
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}

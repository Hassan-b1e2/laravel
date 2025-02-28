<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplierbl extends Model
{
    use HasFactory;
    protected $fillable=['product','quantity','price','totalPrice','supplier','supp_id','bl'];
}

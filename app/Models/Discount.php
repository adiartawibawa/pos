<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Discount extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['name', 'percentage', 'amount', 'start_date', 'end_date', 'is_active'];
}

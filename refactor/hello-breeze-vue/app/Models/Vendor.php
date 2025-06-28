<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * Primary key is 'number' (char(8)) for legacy compatibility.
     */
    protected $primaryKey = 'number';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Disable timestamps: legacy table has no created_at/updated_at.
     */
    public $timestamps = false;

    protected $fillable = ['number', 'name'];
}

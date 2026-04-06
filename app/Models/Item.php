<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'stock', 'harga_sewa_perhari', 'kondisi', 'foto', 'price'
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    // Kurangi stok
    public function reduceStock($amount)
    {
        $this->stock -= $amount;
        $this->save();
    }

    // Tambah stok
    public function addStock($amount)
    {
        $this->stock += $amount;
        $this->save();
    }

    // Cek stok tersedia
    public function hasStock($amount)
    {
        return $this->stock >= $amount;
    }
}
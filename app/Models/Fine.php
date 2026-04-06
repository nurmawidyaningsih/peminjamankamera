<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fine extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'loan_id',
        'user_id',
        'item_id',
        'fine_type',
        'amount',
        'description',
        'status',
        'paid_at',
    ];
    
    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];
    
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    
    public function markAsPaid()
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }
    
    public function markAsWaived()
    {
        $this->update([
            'status' => 'waived',
        ]);
    }
}
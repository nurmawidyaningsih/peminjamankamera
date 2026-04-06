<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'loan_id',
        'action_type',
        'description',
        'details',
    ];
    
    protected $casts = [
        'details' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get the user that owns the log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the loan associated with the log.
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id'); // Tambahkan foreign key
    }
    
    /**
     * Get the item associated through loan.
     */
    public function item()
    {
        return $this->hasOneThrough(Item::class, Loan::class, 'id', 'id', 'loan_id', 'item_id');
    }
}
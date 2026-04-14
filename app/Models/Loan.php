<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_BORROWED = 'borrowed';
    const STATUS_RETURNED = 'returned';
    const STATUS_REJECTED = 'rejected';

    // Return condition constants
    const CONDITION_GOOD = 'good';
    const CONDITION_DAMAGED = 'damaged';
    const CONDITION_LOST = 'lost';

protected $fillable = [
    'user_id', 'item_id', 'description', 'borrow_date',
    'return_date', 'status', 'amount', 'approved_by', 'approved_at',
    'returned_by', 'returned_at', 'rejected_by', 'rejected_at', 'rejection_reason',
    'return_condition', 'damage_description', 'fine_amount', 'transaction_code',
    'payment_method',  // ← TAMBAHKAN INI!
    'quantity'
];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'approved_at' => 'datetime',
        'returned_at' => 'datetime',
        'rejected_at' => 'datetime',
        'fine_amount' => 'decimal:2',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function returnedBy()
    {
        return $this->belongsTo(User::class, 'returned_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    // Status check methods
    public function isPending() 
    { 
        return $this->status === self::STATUS_PENDING; 
    }
    
    public function isApproved() 
    { 
        return $this->status === self::STATUS_APPROVED; 
    }
    
    public function isBorrowed() 
    { 
        return $this->status === self::STATUS_BORROWED; 
    }
    
    public function isReturned() 
    { 
        return $this->status === self::STATUS_RETURNED; 
    }
    
    public function isRejected() 
    { 
        return $this->status === self::STATUS_REJECTED; 
    }

    // Generate transaction code
    public static function generateTransactionCode()
    {
        return 'TRX-' . date('Ymd') . '-' . strtoupper(uniqid());
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        return [
            self::STATUS_PENDING => 'Menunggu Persetujuan',
            self::STATUS_APPROVED => 'Disetujui',
            self::STATUS_BORROWED => 'Dipinjam',
            self::STATUS_RETURNED => 'Dikembalikan',
            self::STATUS_REJECTED => 'Ditolak',
        ][$this->status] ?? $this->status;
    }

    public function getReturnConditionLabelAttribute()
    {
        return [
            self::CONDITION_GOOD => 'Baik',
            self::CONDITION_DAMAGED => 'Rusak',
            self::CONDITION_LOST => 'Hilang',
        ][$this->return_condition] ?? '-';
    }
    
    // Get status badge class
    public function getStatusBadgeClassAttribute()
    {
        return [
            self::STATUS_PENDING => 'pending',
            self::STATUS_APPROVED => 'approved',
            self::STATUS_BORROWED => 'borrowed',
            self::STATUS_RETURNED => 'returned',
            self::STATUS_REJECTED => 'rejected',
        ][$this->status] ?? 'default';
    }

    // app/Models/Loan.php
public function fines()
{
    return $this->hasMany(Fine::class);
}

public function getTotalFineAttribute()
{
    return $this->fines()->where('status', 'pending')->sum('amount');
}

public function calculateLateFine()
{
    if ($this->returned_at && $this->return_date) {
        $returnDate = \Carbon\Carbon::parse($this->return_date);
        $actualReturnDate = \Carbon\Carbon::parse($this->returned_at);
        
        if ($actualReturnDate->gt($returnDate)) {
            $daysLate = $returnDate->diffInDays($actualReturnDate);
            $lateFine = $daysLate * 5000; // Rp 5.000 per hari
            
            $existingFine = $this->fines()->where('fine_type', 'late')->first();
            
            if (!$existingFine) {
                return Fine::create([
                    'loan_id' => $this->id,
                    'user_id' => $this->user_id,
                    'item_id' => $this->item_id,
                    'fine_type' => 'late',
                    'amount' => $lateFine,
                    'description' => "Keterlambatan {$daysLate} hari (@Rp 5.000/hari)",
                    'status' => 'pending',
                ]);
            }
        }
    }
    return null;
}

public function calculateDamageFine($condition, $description = null)
{
    $itemPrice = $this->item->price ?? 100000;
    $fineAmount = 0;
    $fineType = '';
    $fineDescription = '';
    
    if ($condition == 'damaged') {
        $fineAmount = $itemPrice * 0.5;
        $fineType = 'damage';
        $fineDescription = "Kerusakan barang: " . ($description ?? 'Kerusakan tidak spesifik');
    } elseif ($condition == 'lost') {
        $fineAmount = $itemPrice;
        $fineType = 'lost';
        $fineDescription = "Kehilangan barang: " . ($description ?? 'Barang hilang');
    }
    
    if ($fineAmount > 0) {
        return Fine::create([
            'loan_id' => $this->id,
            'user_id' => $this->user_id,
            'item_id' => $this->item_id,
            'fine_type' => $fineType,
            'amount' => $fineAmount,
            'description' => $fineDescription,
            'status' => 'pending',
        ]);
    }
    
    return null;
}
}
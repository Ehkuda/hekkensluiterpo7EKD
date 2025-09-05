<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_name',
        'visitor_id_document',
        'visitor_email',
        'visitor_phone',
        'detainee_id',
        'requested_visit_time',
        'reason_for_visit',
        'status',
        'staff_notes',
        'reviewed_by',
        'reviewed_at',
        'visit_id',
    ];

    protected $casts = [
        'requested_visit_time' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public function detainee()
    {
        return $this->belongsTo(Gedetineerde::class, 'detainee_id');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function getStatusColorClass()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'text-yellow-600',
            self::STATUS_APPROVED => 'text-green-600',
            self::STATUS_REJECTED => 'text-red-600',
            default => 'text-gray-600',
        };
    }

    public function getStatusDisplayName()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'In afwachting',
            self::STATUS_APPROVED => 'Goedgekeurd',
            self::STATUS_REJECTED => 'Afgewezen',
            default => 'Onbekend',
        };
    }
}
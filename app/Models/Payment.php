<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory, HasAuthor;

    const TABLE = 'payments';

    protected $table = self::TABLE;

    protected $fillable = [
        'period_id',
        'term_id',
        'student_uuid',
        'paid_by',
        'amount',
        'initial',
        'balance',
        'payable',
        'trans_id',
        'ref_id',
        'type',
        'category',
        'method',
        'receipt',
        'author_id'
    ];

    protected $casts = [
        'status'  => 'boolean', 
    ];

    public function id(): string
    {
        return $this->id;
    }

    public function status(): bool
    {
        return $this->status;
    }

    public function paidBy(): string
    {
        return (string) $this->paid_by;
    }

    public function amount(): ?int
    {
        return (int) $this->amount;
    }

    public function initial(): ?int
    {
        return (int) $this->initial;
    }

    public function balance(): ?int
    {
        return (int) $this->balance;
    }

    public function payable(): ?int
    {
        return (int) $this->payable;
    }

    public function type(): string
    {
        return (string) $this->payment_type;
    }

    public function category(): string
    {
        return (string) $this->payment_category;
    }

    public function channel(): string
    {
        return (string) $this->channel;
    }

    public function transactionId(): string
    {
        return (string) $this->trans_id;
    }
    
    public function referenceId(): string
    {
        return (string) $this->ref_id;
    }

    public function createdAt()
    {
        return $this->created_at->format('d-m-Y');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_uuid');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return  $query->whereHas('student', function($query) use ($term){
            $query->where('first_name', 'like', $term)
                ->orWhere('last_name', 'like', $term)
                ->orWhere('other_name', 'like', $term)
                ->orWhere('uuid', 'like', $term);
        });
    }

    public function scopeLoadLatest(Builder $query, $count = 4)
    {
        return $query->paginate($count);
    }

     public function getCategoryAttribute()
    {

        $category = [
            'ecommerce' => 'Ecommerce Service',
            'school_fees' => 'School Fee Service',
            'schoolbus_service' => 'School Bus Service',

        ];

        return $category[$this->payment_category];
    }

    /**
     * Return full public URL to receipt if exists
     */
    public function getReceiptUrlAttribute()
    {
        if (empty($this->receipt)) {
            return null;
        }

        if (Storage::exists($this->receipt)) {
            return asset('storage/' . $this->receipt);
        }

        return null;
    }

    public function getPaymentStatusAttribute()
    {

        $status = [
            'full' => 'Full Payment',
            'partial' => 'Partial Payment',
        ];

        return $status[$this->payment_type];
    }

    public function getPaymentBadgeAttribute()
    {

        $status = [
            'full' => 'badge bg-success',
            'partial' => 'badge bg-info',
        ];

        return $status[$this->payment_type];
    }
}
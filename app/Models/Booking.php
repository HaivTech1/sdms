<?php

namespace App\Models;

use App\Traits\HasUser;
use App\Models\Property;
use App\Models\Amenities;
use App\Traits\HasAuthor;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{
    use HasFactory;
    use HasAuthor;
    use HasUuid;

    const TABLE = 'bookings';
    protected $table = self::TABLE;

    protected $fillable = [
        'uuid',
        'property_uuid',
        'author_id',
        'paymentMethod',
        'total',
        'isVerified',
        'paymentStatus',
    ];

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $with = [
        'authorRelation', 'property'
    ];

    protected $casts = [
        'isVerified' => 'boolean',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class,'property_uuid');
    }

    public function id(): string
    {
        return (string) $this->uuid;
    }

    public function total(): string
    {
        return (string) $this->total;
    }

    public function createdAt()
    {
        return $this->created_at->format('M, d Y');
    }

    public function payment(): bool
    {
        return (bool) $this->paymentStatus;
    }

    public function verification(): bool
    {
        return (bool) $this->isVerified;
    }
    
    public function getPaymentBadgeAttribute()
    {

        $status = [
            '1' => 'Pending',
            '2' => 'Paid',
            '3' => 'Refund',
            '4' => 'ChargeBack',
        ];

        return $status[$this->paymentStatus];
    }

    public function getVerifyBadgeAttribute()
    {

        $verify = [
            '0' => 'Pending',
            '1' => 'Accepted',
        ];

        return $verify[$this->isVerified];
    }

    public function getPaymentMethodBadgeAttribute()
    {

        $verify = [
            'transfer' => 'fab fa-cc-mastercard me-1',
            'paystack' => 'fab fa-cc-Paypal me-1',
        ];

        return $verify[$this->paymentMethod];
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('uuid', 'like', $term);
        });
    }

}
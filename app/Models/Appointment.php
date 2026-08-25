<?php

// app/Models/Appointment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    // use HasFactory;

    // Explicit allow-list (no $guarded = []) to prevent mass assignment of
    // columns like id/timestamps or unexpected fields.
    protected $fillable = [
        'user_id',
        'title',
        'procedure',
        'duration',
        'time',
        'start',
        'end',
        'status',
        'image_path',
        'teeth_layout',
        'total_price',
        'down_payment',
        'payment_method',
        'payment_reference',
        'payment_status',
        'requires_payment',
        'reminder_sent_at',
        'reviewed_at',
    ];
    
    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relationship to Feedback
    public function feedback()
    {
        return $this->hasOne(ServiceFeedback::class);
    }
    
    // Relationship to Cancellations
    public function cancellations()
    {
        return $this->hasMany(AppointmentCancellation::class);
    }
    
}

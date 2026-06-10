<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'locale',
        'profile_photo_path',
        'phone',
        'city',
        'bio_en',
        'bio_ku',
        'theme_preference',
        'verified_at',
        'username_changed_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified_mechanic' => 'boolean',
            'username_changed_at' => 'datetime',
        ];
    }

    // Profile Photo URL Accessor
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=F47920&color=fff';
    }

    // Check if user can change username (once per week)
    public function canChangeUsername()
    {
        if (!$this->username_changed_at) {
            return true;
        }
        
        return $this->username_changed_at->diffInDays(now()) >= 7;
    }

    // Get days until next username change
    public function getDaysUntilUsernameChange()
    {
        if (!$this->username_changed_at) {
            return 0;
        }
        
        $daysPassed = $this->username_changed_at->diffInDays(now());
        $daysRemaining = 7 - $daysPassed;
        
        return $daysRemaining > 0 ? $daysRemaining : 0;
    }

    // Relationships
    public function savedItems()
    {
        return $this->hasMany(SavedItem::class);
    }

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'user_cars')->withTimestamps();
    }

    public function ownedCars()
    {
        return $this->cars();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function mechanicDetail()
    {
        return $this->hasOne(MechanicDetail::class);
    }

    public function mechanicDocument()
    {
        return $this->hasOne(MechanicDocument::class, 'user_id');
    }

    public function savedCars()
    {
        return $this->savedItems()->where('item_type', 'car');
    }

    public function savedParts()
    {
        return $this->savedItems()->where('item_type', 'part');
    }

    public function savedMechanics()
    {
        return $this->savedItems()->where('item_type', 'mechanic');
    }

    public function savedFaultCodes()
    {
        return $this->savedItems()->where('item_type', 'fault_code');
    }

    // Helper methods
    public function isMechanic()
    {
        return $this->role === 'mechanic';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at) || !is_null($this->verified_at);
    }

    public function isVerifiedMechanic()
    {
        return $this->is_verified_mechanic == true;
    }

    public function hasSubmittedDocuments()
    {
        $doc = $this->mechanicDocument;
        return $doc && $doc->status !== 'pending';
    }

    public function getMechanicVerificationStatus()
    {
        if ($this->is_verified_mechanic) {
            return 'verified';
        }
        
        $doc = $this->mechanicDocument;
        if ($doc) {
            return $doc->status;
        }
        
        return 'not_submitted';
    }

    public function hasSaved($type, $id)
    {
        return $this->savedItems()
            ->where('item_type', $type)
            ->where('item_id', $id)
            ->exists();
    }

    public function saveItem($type, $id)
    {
        if (!$this->hasSaved($type, $id)) {
            return $this->savedItems()->create([
                'item_type' => $type,
                'item_id' => $id,
            ]);
        }
        return null;
    }

    public function unsaveItem($type, $id)
    {
        return $this->savedItems()
            ->where('item_type', $type)
            ->where('item_id', $id)
            ->delete();
    }

    public function toggleSave($type, $id)
    {
        if ($this->hasSaved($type, $id)) {
            $this->unsaveItem($type, $id);
            return false;
        } else {
            $this->saveItem($type, $id);
            return true;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }
}
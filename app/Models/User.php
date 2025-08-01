<?php

namespace App\Models;

use App\Enums\User\UserRole;
use App\Enums\User\UserStatus;
use App\Support\DateFormatter;
use App\Database\Configs\Table;
use App\Enums\NotificationType;
use App\Enums\User\FollowStatus;
use Laravel\Sanctum\HasApiTokens;
use App\Services\World\WorldService;
use Illuminate\Notifications\Notifiable;
use App\Models\Traits\User\FetchesDrafts;
use App\Support\Casts\ModelTimestampCast;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Traits\Pagination\SupportsManualPagination;

class User extends Authenticatable
{
    use FetchesDrafts, 
        SupportsManualPagination,
        Notifiable,
        SoftDeletes,
        HasApiTokens,
        Notifiable,
        HasFactory;

    public $table = Table::USERS;

    public static $snakeAttributes = true;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'verified' => 'boolean',
            'tips' => 'array',
            'status' => UserStatus::class,
            'role' => UserRole::class,
            'verified_at' => ModelTimestampCast::class
        ];
    }

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function getCreatedAt()
    {
        return new DateFormatter($this->created_at);
    }

    public function getLastActive()
    {
        return new DateFormatter($this->last_active);
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable', 'notifiable_type', 'notifiable_id', 'id');
    }

    public function getUnreadNotificationsCount()
    {
        return $this->unreadNotifications()->count();
    }

    public function story()
    {
        return $this->hasOne(Story::class, 'user_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id', 'id');
    }

    public function linkedAccounts()
    {
        return $this->hasMany(User::class, 'owner_account_id', 'id');
    }

    public function masterAccount()
    {
        return $this->belongsTo(User::class, 'owner_account_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id', 'id');
    }

    public function jobListings()
    {
        return $this->hasMany(JobListing::class, 'user_id', 'id');
    }

    public function advertising()
    {
        return $this->hasMany(Ad::class, 'user_id', 'id');
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable', 'reportable_type', 'reportable_id', 'id');
    }

    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'linkable', 'linkable_type', 'linkable_id', 'id')
            ->whereIn('platform', array_column(social_links(), 'platform'));
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id', 'id')->with('follower');
    }

    public function privacySettings()
    {
        return $this->hasOne(UserPrivacySettings::class, 'user_id', 'id');
    }

    public function permitSettings()
    {
        return $this->hasOne(UserPermitSettings::class, 'user_id', 'id');
    }

    public function emailNotificationSettings()
    {
        return $this->hasOne(UserNotificationSettings::class, 'user_id', 'id')->where('type', NotificationType::EMAIL);
    }

    public function pushNotificationSettings()
    {
        return $this->hasOne(UserNotificationSettings::class, 'user_id', 'id')->where('type', NotificationType::PUSH);
    }

    public function securitySettings()
    {
        return $this->hasOne(UserSecuritySettings::class, 'user_id', 'id');
    }

    public function followings()
    {
        return $this->hasMany(Follow::class, 'follower_id', 'id')->with('following');
    }

    public function isFollowing(User $user)
    {
        return Follow::where([
            'follower_id' => $this->id,
            'following_id' => $user->id,
            'status' => FollowStatus::FOLLOWING
        ])->exists();
        
        return false;
    }

    public function follow(User $user)
    {
        if($user->permitSettings->followers->onlyApproved()) {
            $follow = Follow::create([
                'follower_id' => $this->id,
                'following_id' => $user->id,
                'status' => FollowStatus::REQUESTED
            ]);

            return $follow;
        }
        else {
            $follow = Follow::create([
                'follower_id' => $this->id,
                'following_id' => $user->id,
                'status' => FollowStatus::FOLLOWING
            ]);

            $user->increment('followers_count', 1);
            $this->increment('following_count', 1);

            return $follow;
        }
    }

    public function acceptFollowRequest(User $user)
    {
        $follow = Follow::where([
            'follower_id' => $user->id,
            'following_id' => $this->id,
            'status' => FollowStatus::REQUESTED
        ])->first();

        if($follow) {
            $follow->update([
                'status' => FollowStatus::FOLLOWING
            ]);

            $user->increment('following_count');
            $this->increment('followers_count');
        }

        return $follow;
    }

    public function unFollow(User $user)
    {
        Follow::where([
            'follower_id' => $this->id,
            'following_id' => $user->id
        ])->delete();
        
        $user->decrement('followers_count', 1);
        $this->decrement('following_count', 1);
    }

    public function followRequested(User $user)
    {
        return Follow::where([
            'follower_id' => $this->id,
            'following_id' => $user->id,
            'status' => FollowStatus::REQUESTED
        ])->exists();

        return false;
    }

    public function canFollow(User $user)
    {
        return $this->id !== $user->id;
    }

    public function scopeExcludeSelf($query)
    {
        return $query->where('id', '!=', me()->id);
    }

    public function scopeActive($query)
    {
        return $query->where('status', UserStatus::ACTIVE);
    }

    public function scopeActiveByUsername($query, $username)
    {
        return $query->active()->where('username', $username);
    }

    public function scopeActiveById($query, $id)
    {
        return $query->active()->where('id', $id);
    }

    public function getCaption()
    {
        if(empty($this->caption)) {
            return "@{$this->username}";
        }

        return $this->caption;
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getCountryNameAttribute()
    {
        if($this->country === null) {
            return "";
        }
        
        return (new WorldService)->getCountryName($this->country);
    }

    public function getBirthDateAttribute()
    {
        
        $monthName = __('labels.months.' . $this->birth_month);
        return "{$this->birth_day} {$monthName}, {$this->birth_year}";
    }

    public function getHasTipsAttribute()
    {
        return empty($this->tips) != true;
    }

    public function hasDefaultAvatar()
    {
        return $this->avatar == config('user.avatar');
    }

    public function hasDefaultCover()
    {
        return $this->cover == config('user.cover');
    }

    public function getAvatarUrlAttribute()
    {
        if (empty($this->avatar) || $this->hasDefaultAvatar()) {
            return asset(config('user.avatar'));
        }

        return storage_url($this->avatar, config('user.disks.avatar'));
    }

    public function getCoverUrlAttribute()
    {
        if (empty($this->cover) || $this->hasDefaultCover()) {
            return asset(config('user.cover'));
        }

        return storage_url($this->cover, config('user.disks.cover'));
    }

    public function getProfileUrlAttribute()
    {
        return url("@{$this->username}");
    }

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class, 'user_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'user_id', 'id');
    }

    public function isAdmin()
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isOnline()
    {
        return $this->getLastActive()->isGt(now()->subMinutes(config('user.online_interval_in_minutes')));
    }

    public function decrementValue(string $columnName, int $value = 1)
    {
        $columnNewValue = ($this->$columnName - $value);

        $this->update([
            $columnName => ($columnNewValue > 0) ? $columnNewValue : 0
        ]);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function businessAccount()
    {
        return $this->hasOne(BusinessAccount::class, 'user_id', 'id');
    }

    public function isMasterAccount()
    {
        return empty($this->owner_account_id);
    }

    public function isVerified()
    {
        return $this->verified;
    }
}

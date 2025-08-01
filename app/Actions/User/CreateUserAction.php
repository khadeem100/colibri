<?php
/*
|--------------------------------------------------------------------------
| ColibriPlus - The Social Network Web Application.
|--------------------------------------------------------------------------
| Author: Mansur Terla. Full-Stack Web Developer, UI/UX Designer.
| Website: www.terla.me
| E-mail: mansurtl.contact@gmail.com
| Instagram: @mansur_terla
| Telegram: @mansurtl_contact
|--------------------------------------------------------------------------
| Copyright (c)  ColibriPlus. All rights reserved.
|--------------------------------------------------------------------------
*/

namespace App\Actions\User;

use App\Models\User;
use App\Enums\F2AType;
use App\Models\Wallet;
use Illuminate\Support\Str;
use App\Enums\NotificationType;
use App\Models\UserNotificationSettings;

class CreateUserAction
{
    public $userData;

    public function __construct(array $userData = [])
    {
        $this->userData = $userData;
    }

    public function execute()
    {
        $userData = User::create(array_merge([
            'username' => '',
            'category' => config('user.category'),
            'email' => '',
            'password' => '',
            'avatar' => null,
            'cover' => config('user.cover'),
            'language' => config('user.language'),
            'gender' => config('user.gender'),
            'verified' => config('user.verified'),
            'tips' => config('user.tips'),
            'theme' => theme_name(),
            'last_active' => now(),
            'ip_address' => request()->ip()
        ], $this->userData));

        $userData->wallet()->create([
            'wallet_number' => $this->generateUniqueWalletNumber(),
            'balance' => config('wallet.default_balance'),
        ]);

        // Create privacy settings (Default all are set to: false)
        $userData->privacySettings()->create([]);

        // Create permit settings (Default all are set to: all)
        $userData->permitSettings()->create([]);

        // Create email notification settings (Default all are set to: false)
        UserNotificationSettings::create([
            'user_id' => $userData->id,
            'type' => NotificationType::EMAIL
        ]);

        // Create push notification settings (Default all are set to: false)
        UserNotificationSettings::create([
            'user_id' => $userData->id,
            'type' => NotificationType::PUSH
        ]);

        // Create security settings (Default all are set to: false)
        $userData->securitySettings()->create([
            '2fa' => false,
            '2fa_type' => F2AType::EMAIL,
            'login_notification' => false,
            'login_notification_type' => NotificationType::EMAIL
        ]);

        $userData->businessAccount()->create([
            'name' => $userData->name,
            'billing_address' => []
        ]);

        return $userData;
    }

    private function generateUniqueWalletNumber()
    {
        do {
            $number = strtoupper(Str::random(16));

            $prefix = config('wallet.wallet_number_prefix');

            if($prefix) {
                $number = "{$prefix}-{$number}";
            }
        } 
        
        while (Wallet::where('wallet_number', $number)->exists());

        return $number;
    }
}

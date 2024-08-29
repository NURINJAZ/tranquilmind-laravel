<?php

namespace App\Actions\Fortify;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'experience' => ['nullable', 'integer', 'min:0', 'max:100'],
            'bio_data' => ['nullable', 'string'],
            'category' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'in:hospital,clinic,counselling'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
        }

        // Mapping location to coordinates
        $locationCoordinates = [
            'hospital' => '2.3049829727398152, 102.42854912806172',
            'clinic' => '2.3121050230235127, 102.43048650479567',
            'counselling' => '2.2260851662954586, 102.45449001120441',
        ]; 

        $coordinates = $locationCoordinates[$input['location']] ?? null;

        Doctor::where('doc_id', $user->id)
            ->update([
                'experience' => $input['experience'],
                'bio_data' => $input['bio_data'],
                'category' => $input['category'],
                'coordinate' => $coordinates,
            ]);
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}

<?php

namespace App\Livewire\Investors; // New namespace

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\InvestorProfile; // Use InvestorProfile model
use App\Enums\UserRole;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Manage extends Component
{
    use WithFileUploads;

    // User related fields
    public $userId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $avatar;
    public $currentAvatar;
    public $phone;
    public $is_active = true; // For the User record

    // Investor Profile related fields
    public $investorProfileId;
    public $company_name;
    public $investment_focus;
    public $website;
    public $contact_person_name;
    public $contact_person_email;
    public $contact_person_phone;
    public $address;
    public $city;
    public $state;
    public $zip_code;
    public $country;
    public $min_investment_amount;
    public $max_investment_amount;
    public $notes;
    public $is_approved = false; // For the Investor Profile record

    public $isEditing = false;
    public $pageTitle = 'Create New Investor Profile';

    public function mount($investorProfileId = null)
    {
        if ($investorProfileId) {
            $investorProfile = InvestorProfile::with('user')->find($investorProfileId);

            if (!$investorProfile || $investorProfile->user->role !== UserRole::Investor) {
                session()->flash('error', 'Investor Profile not found or user is not an investor.');
                return $this->redirect(route('investors.index'), navigate: true);
            }

            $this->isEditing = true;
            $this->investorProfileId = $investorProfile->id;
            $this->userId = $investorProfile->user->id;

            // Load User data
            $this->name = $investorProfile->user->name;
            $this->email = $investorProfile->user->email;
            $this->currentAvatar = $investorProfile->user->avatar;
            $this->phone = $investorProfile->user->phone;
            $this->is_active = $investorProfile->user->is_active;

            // Load Investor Profile data
            $this->company_name = $investorProfile->company_name;
            $this->investment_focus = $investorProfile->investment_focus;
            $this->website = $investorProfile->website;
            $this->contact_person_name = $investorProfile->contact_person_name;
            $this->contact_person_email = $investorProfile->contact_person_email;
            $this->contact_person_phone = $investorProfile->contact_person_phone;
            $this->address = $investorProfile->address;
            $this->city = $investorProfile->city;
            $this->state = $investorProfile->state;
            $this->zip_code = $investorProfile->zip_code;
            $this->country = $investorProfile->country;
            $this->min_investment_amount = $investorProfile->min_investment_amount;
            $this->max_investment_amount = $investorProfile->max_investment_amount;
            $this->notes = $investorProfile->notes;
            $this->is_approved = $investorProfile->is_approved;

            $this->pageTitle = 'Edit Investor Profile: ' . $this->company_name;
        } else {
            // Default values for new investor
            $this->is_active = true;
            $this->is_approved = false;
            $this->pageTitle = 'Create New Investor Profile';
        }
    }

    protected function rules()
    {
        return [
            // User Validation
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->userId),
            ],
            'password' => $this->isEditing ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|max:1024',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',

            // Investor Profile Validation
            'company_name' => 'nullable|string|max:255',
            'investment_focus' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_email' => 'nullable|email|max:255',
            'contact_person_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'min_investment_amount' => 'nullable|numeric|min:0',
            'max_investment_amount' => 'nullable|numeric|min:0|gte:min_investment_amount',
            'notes' => 'nullable|string',
            'is_approved' => 'boolean',
        ];
    }

    protected $messages = [
        'email.unique' => 'This email is already registered. Please use another one.',
        'password.confirmed' => 'The password confirmation does not match.',
        'password.min' => 'The password must be at least 8 characters.',
        'website.url' => 'The website must be a valid URL.',
        'max_investment_amount.gte' => 'Max investment amount must be greater than or equal to min investment amount.',
    ];

    public function saveInvestor() // Changed method name
    {
        $this->validate();

        // Prepare User data
        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => UserRole::Investor, // Explicitly set role
            'is_active' => $this->is_active,
            // Additional user fields like date_of_birth, gender, slug would go here if needed for investors
        ];

        if (!empty($this->password)) {
            $userData['password'] = Hash::make($this->password);
        }

        // Handle avatar upload
        if ($this->avatar) {
            if ($this->currentAvatar && Storage::disk('public')->exists($this->currentAvatar)) {
                Storage::disk('public')->delete($this->currentAvatar);
            }
            $userData['avatar'] = $this->avatar->store('avatars', 'public');
        } elseif (!$this->avatar && $this->currentAvatar) {
            $userData['avatar'] = $this->currentAvatar;
        } else {
            $userData['avatar'] = null;
        }


        // Prepare Investor Profile data
        $investorProfileData = [
            'company_name' => $this->company_name,
            'investment_focus' => $this->investment_focus,
            'website' => $this->website,
            'contact_person_name' => $this->contact_person_name,
            'contact_person_email' => $this->contact_person_email,
            'contact_person_phone' => $this->contact_person_phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'country' => $this->country,
            'min_investment_amount' => $this->min_investment_amount,
            'max_investment_amount' => $this->max_investment_amount,
            'notes' => $this->notes,
            'is_approved' => $this->is_approved,
            'is_active' => $this->is_active, // Mirror user's active status or manage independently
        ];


        if ($this->isEditing) {
            $user = User::find($this->userId);
            $user->update($userData);

            $investorProfile = InvestorProfile::find($this->investorProfileId);
            $investorProfile->update($investorProfileData);

            session()->flash('message', 'Investor Profile updated successfully!');
        } else {
            $user = User::create($userData); // Create User first
            $user->investorProfile()->create($investorProfileData); // Then create associated Investor Profile

            session()->flash('message', 'Investor Profile created successfully!');
        }

        return redirect()->route('investors.index'); // Changed route
    }

    public function render()
    {
        return view('livewire.investors.manage'); // Changed view path
    }
}

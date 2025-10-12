<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',        // Added by add_info_to_users_table
        'phone',         // Added by add_info_to_users_table
        'address',       // Added by add_info_to_users_table
        'city',          // Added by add_info_to_users_table
        'state',         // Added by add_info_to_users_table
        'zip_code',      // Added by add_info_to_users_table
        'country',       // Added by add_info_to_users_table
        'role',          // Added by add_info_to_users_table
        'is_active',     // Added by add_info_to_users_table

        // Uncomment these if you decided to add them in the migration
        'date_of_birth',
        'gender',
        'slug',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean', // Cast to boolean
            'role' => UserRole::class, // Cast to our custom UserRole enum
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * A user can have one vendor profile if they are a vendor.
     */
    public function vendorProfile()
    {
        return $this->hasOne(VendorProfile::class); // Assuming VendorProfile model exists
    }

    /**
     * A user (vendor) can have many products.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id'); // Assuming Product model exists
    }

    /**
     * A user (customer) can place many orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class); // Assuming Order model exists
    }

    /**
     * A user can write many reviews.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class); // Assuming Review model exists
    }

    /**
     * A user can have many addresses.
     */
    public function addresses()
    {
        return $this->hasMany(Address::class); // Assuming Address model exists
    }

    /**
     * A user can have many items in their wishlist.
     */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class); // Assuming Wishlist model exists
    }

    

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */


    /**
     * Get the full name of the user.
     */
    public function getFullNameAttribute(): string
    {
        return $this->name; // If you later split name into first_name/last_name, update this.
    }


    /**
     * Get the URL to the user's avatar.
     */
    public function getAvatarUrlAttribute(): string
    {
        // If avatar is set, return its path, otherwise return a default placeholder.
        return $this->avatar ? asset('storage/' . $this->avatar) : asset('images/default_avatar.png');
    }



    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if the user is a customer.
     */
    public function isCustomer(): bool
    {
        return $this->role->isCustomer();
    }

    /**
     * Check if the user is a vendor.
     */
    public function isVendor(): bool
    {
        return $this->role->isVendor();
    }

    /**
     * Check if the user is an investor.
     */
    public function isInvestor(): bool
    {
        return $this->role->isInvestor();
    }
}

<?php

namespace App\AlterBase\Models\User;

use App\AlterBase\Models\Setting\Message;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'title',
        'email',
        'password',
        'verified',
        'active',
        'guard',
        'user_type',
        'last_login',
        'online',
        'profile_image',
        'verification_token',
        'stripe_id',
        'subscription_id',
        'pm_type',
        'stripe_id',
        'pm_last_four',
        'trial_ends_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['image'];

    /**
     * @param $password
     * @return string
     */
    public function setPasswordAttribute($password)
    {
        return $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Return true if user has given role
     *
     * @param $role
     * @return bool
     */
    public function hasRole($role, $name = "")
    {
        $role = !is_string($role) ?: app(Role::class)->where(['name' => $name])->firstOrFail();

        if ($role) {
            foreach ($this->roles as $r) {
                if ($r->id == $role->id) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param $slug
     * @return bool
     */
    public function hasPermission($slug)
    {
        $permission = !is_string($slug) ?: app(Permission::class)->where(['slug' => $slug])->first();

        if ($permission) {
            foreach ($this->roles as $role) {
                if ($role->hasPermission($permission)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Check if the user is super admin
     *
     * @return bool
     */
    public function isSuperuser()
    {
        return in_array($this->email, config('auth.superusers'));
    }

    /**
     * User has many roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    /**
     * Get user profile
     *
     * @return Collection
     */
    public function profile()
    {
        return $this->from('users as u')
            ->join('user_profile as p', 'p.user_id', 'u.id')
            ->where('u.id', $this->id)
            ->select([
                'p.name',
                'p.address',
                'p.contact',
                'p.contact_person',
                'p.categories',
                'p.mobile',
                'p.postal_code',
                'p.city_id',
                'p.summary',
                'p.description',
                'p.linkedin',
                'p.twitter',
                'p.facebook',
                'p.instagram',
                'p.map'])
            ->get()
            ->first();
    }

    /**
     * Get city from profile
     *
     * @return Collection
     */
    public function city()
    {
        return $this->from('users as u')
            ->join('user_profile as p', 'u.id', 'p.user_id')
            ->join('cities as c', 'p.city_id', 'c.id')
            ->where('u.id', $this->id)
            ->select([
                'c.id',
                'c.name'
                ])
            ->get()
            ->first();
    }

    /**
     * Get user setting
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function setting()
    {
        return $this->hasOne(UserSetting::class, 'user_id', 'id');
    }

    /**
     * User has many messages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inbox()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    /**
     * Get user profile image
     *
     * @return String
     */
    public function getImageAttribute()
    {
        if ($this->profile_image == "user.png") {
            return mpath('cms/dist/img/user.png');
        }

        return mpath('uploads/users/' . $this->profile_image);
    }

    /**
     * Get slug from Users
     * 
     * @return String
     */
    public function getRouteKeyName() {
        return 'slug';  // table column name.
    }

}

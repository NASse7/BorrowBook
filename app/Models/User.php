<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasApiTokens;

    protected $fillable =
    [
        'role_id',
        'created_by',
        'phone',
        'name',
        'password',
        'language',
        'is_active'
    ];
    protected $hidden =
    [
        'password'
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function createdAdmins()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    public function orders()
    {
        return $this->hasMany(BorrowOrder::class);
    }

    public function handledOrders()
    {
        return $this->hasMany(BorrowOrder::class, 'handled_by');
    }

    public function addedBooks()
    {
        return $this->hasMany(Book::class, 'added_by');
    }

    public function notifications()
    {
        return $this->hasMany(AppNotification::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'actor_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(Book::class, 'favorites')->withPivot('added_at');
    }

    public function isSuperAdmin(): bool
    {
        return $this->role->name === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role->name, ['admin', 'super_admin']);
    }
}

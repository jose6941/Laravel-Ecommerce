<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'phone', 'role'];

    protected function casts(): array
    {
        return ['password' => 'hashed']; // criptografa a senha automaticamente ao salvar
    }

    public function orders()    { return $this->hasMany(Order::class); }
    public function addresses() { return $this->hasMany(Address::class); }
    public function cart()      { return $this->hasOne(Cart::class); }

    public function isAdmin(): bool { return $this->role === 'admin'; }
}

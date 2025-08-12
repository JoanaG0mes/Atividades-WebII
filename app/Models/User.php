<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
       use HasFactory, Notifiable, HasRoles; 

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
protected $fillable = [
    'name', 'email', 'password', 'role' // Adicione 'role'
];

// Métodos para verificar papéis
public function isAdmin(): bool {
    return $this->role === 'admin';
}

public function isBibliotecario(): bool {
    return $this->role === 'bibliotecario';
}

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
        ];
    }

public function books()
{
    return $this->belongsToMany(Book::class, 'borrowings')
                ->withPivot('id', 'borrowed_at', 'returned_at')
                ->withTimestamps();
}
}

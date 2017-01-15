<?php

namespace LaravelItalia\Domain;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'users';
    protected $hidden = ['password', 'remember_token'];

    public static function fromNameAndEmailAndPassword($fullName, $emailAddress, $password)
    {
        $user = new self;

        $user->name = $fullName;
        $user->email = $emailAddress;
        $user->password = bcrypt($password);

        $user->is_confirmed = false;
        $user->confirmation_code = sha1(microtime().$user->email);

        $user->is_blocked = false;

        return $user;
    }

    public static function fromDiscourseUserNameAndEmail($fullName, $emailAddress)
    {
        $user = new self;

        $user->name = $fullName;
        $user->email = $emailAddress;
        $user->password = '';

        $user->is_confirmed = true;
        $user->confirmation_code = '';

        $user->is_blocked = false;

        return $user;
    }

    public function confirm()
    {
        if ($this->is_confirmed) {
            throw new \Exception('already_confirmed');
        }

        $this->is_confirmed = true;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setNewPassword($newPassword)
    {
        $this->password = bcrypt($newPassword);
    }

    /* Relationships Methods */

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function mapEntries()
    {
        return $this->hasMany(MapEntry::class);
    }

    /* Relationships Utility Methods */

    public function isAdministrator()
    {
        return $this->role->name === 'administrator';
    }

    public function isAuthorOf(Article $article)
    {
        return $this->id === $article->user_id;
    }
}

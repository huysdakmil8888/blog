<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mail;
use Str;

class LoginToken extends Model
{
    protected $guarded=[];

    public function getRouteKeyName()
    {
        return 'token';
    }
    public static function generateFor(User $user)
    {
        return static::create([
            'user_id'=>$user->id,
            'token'=>Str::random(50)
        ]);

    }

    public function send()
    {
        $url=url('/auth/token/'.$this->token);
        Mail::raw(
            "<a href='{$url}'>{$url}</a>",
            function($message){
                $message->to($this->user->email)
                    ->subject('login to laracasts');
            }
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }
}

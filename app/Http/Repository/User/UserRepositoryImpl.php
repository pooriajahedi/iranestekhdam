<?php


namespace App\Http\Repository\User;


use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserRepositoryImpl implements UserRepository
{

    function IsUserExists($telegramId): bool
    {
        $User = User::where('chat_id', $telegramId)->first();
        return (bool)$User;
    }

    function AddUser($name, $userName, $chat_id): bool
    {
        $User = User::create([
            "name" => $name?? '',
            "user_name" => $userName?? '',
            "chat_id" => $chat_id
        ]);
        Log::debug("New User Registered : ".$User);
        return true;

    }

    function GetCurrentUser($chat_id): User
    {
        return User::where('chat_id',request('message.from.id'))->first();
    }

    function ChangeMenuState($chat_id, $state): bool
    {
        $User=$this->GetCurrentUser($chat_id);
        $User->step=$state;
        $User->save();
        return true;
    }
}

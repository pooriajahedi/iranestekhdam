<?php


namespace App\Http\Repository\User;


use App\Models\User;

interface UserRepository
{
    function IsUserExists($telegramId): bool;

    function AddUser($name,$userName,$chat_id): bool;

    function GetCurrentUser($chat_id): User;

    function ChangeMenuState($chat_id,$state): bool;
}

<?php
/*
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;


class RefreshMessageController extends Controller
{
    public function checkNewMessages()
{
    $newMessages = Message::where('user_id', auth()->id())
                          ->where('is_read', false)
                          ->get();

    return response()->json($newMessages);
}

}
*/
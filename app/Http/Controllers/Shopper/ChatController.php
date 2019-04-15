<?php

namespace App\Http\Controllers\Shopper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Musonza\Chat\Models\ConversationUser;
use Musonza\Chat\Models\MessageNotification;
use Validator;
use App\User;
use Auth;
use Chat;

class ChatController extends Controller
{
    /* Get All Conversations */
	public function getAllConversations()
	{
		$conversations = Chat::conversations()->for(Auth::user())->get();

		foreach($conversations as $conv)
		{	
			$user = ConversationUser::where('user_id', '<>', Auth::user()->id)->where('conversation_id', $conv['id'])->first();

			$user_data = User::with(['getRole'])->where('id', $user['user_id'])->first();

			$conv['user'] = $user_data;

			/* Get unread message count */
			$count = Chat::conversation($conv)->for(Auth::user())->unreadCount();

			$conv['unread_count'] = $count;
		}
		
		$users = User::with(['getRole'])->whereHas('roles', function($q){
        			$q->where('name', 'admin')->orWhere('name', 'host');
        		 })->get();

		return view('shopper.conversations')->with(['conversations' => $conversations, 'users' => $users]);
	}

	/* Get all messages of chat */
    public function getChat($id)
    {
    	$conversation = Chat::conversations()->between(Auth::user(), $id);
    	if($conversation != null)
    	{
    		$messages = Chat::conversation($conversation)->for(Auth::user())->getMessages();

    		/* Check if any message is unread in conversation */
    		$unread = Chat::conversation($conversation)->for(Auth::user())->unreadCount();
    		
    		if($unread)
    		{
    			/* Mark messages as read */
    			foreach($messages as $msg)
    			{
    				$mark_read = Chat::message($msg)->for(Auth::user())->markRead();
    			}
    		}
    	}
    	else
    	{
    		$messages="";
    	}

        $conv_with_user = User::with(['getRole'])->where('id', $id)->first();

		return view('shopper.chat_view')->with(['messages' => $messages, 'conv_with_user' => $conv_with_user]);
    }

    /* Send message */
    public function sendMessage(Request $request)
    {
    	
    	$validator = Validator::make($request->all(),
        [
            'message' => ['required'],
        ], ['message.required' => 'Please write a message.']);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $check_conversation_exists = Chat::conversations()->between(Auth::user(), $request->id);

        if($check_conversation_exists == null)
        {
        	$participants = [Auth::user()->id, $request->id];
			$conversation = Chat::createConversation($participants);
        }
        else
        {
        	$conversation = $check_conversation_exists;
        }

		$message = Chat::message($request->message)
	            ->from(Auth::user())
	            ->to($conversation)
	            ->send();

		return redirect()->back();
    }

    /* Get Unread Conversations */
    public function getUnreadConversations()
    {
        $conversations = Chat::conversations()->for(Auth::user())->get();
        
        if($conversations)
        {
            foreach($conversations as $conv)
            {
                $unreadCount = Chat::conversation($conv)->for(Auth::user())->unreadCount();

                $conv['unread'] = $unreadCount;

                $get_receiver_id = MessageNotification::where('conversation_id', $conv['id'])->where('user_id', '<>', Auth::user()->id)->first();

                $user = User::where('id', $get_receiver_id['user_id'])->first();

                $conv['user'] = $user;
            }

            $unread_list = view('shopper.renders.unread_conversations_list_render')->with('conversations', $conversations)->render();
            
            return response()->json(['status' => 'success', 'conversations' => $unread_list]);
        }
        return response()->json(['status' => 'success', 'conversations' => '']);
    }
}

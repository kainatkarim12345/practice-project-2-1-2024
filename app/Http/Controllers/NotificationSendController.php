<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Notification;

class NotificationSendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function updateDeviceToken(Request $request)
    {
        // dd($request);
        Auth::user()->device_token =  $request->token;

        Auth::user()->save();

        return response()->json(['Token successfully stored.']);
    }

    public function sendNotification(Request $request)
    {
        
        try{
            $validator = $this->validate($request, [
                'title' => 'required',
                'body' => 'required',
            ]);

            $url = 'https://fcm.googleapis.com/fcm/send';

            $FcmToken = User::whereNotNull('device_token')->pluck('device_token')->all();
                
            $serverKey = 'AAAAQf8ypGw:APA91bF5MUyEAlPtseyEnvlCDHRZSxPjTxcrYSw51JD4rsUymMS0juCMPmE7NEstarBjlI-dqBz6VfIL354h5I5hyuAZusOoDqb1FhXjE_o9bqbshlzZ9yyT5QkcuoJWU1z225NYzbO8'; // ADD SERVER KEY HERE PROVIDED BY FCM
        
            $data = [
                "registration_ids" => $FcmToken,
                "notification" => [
                    "title" => $request->title,
                    "body" => $request->body,  
                ]
            ];
            $encodedData = json_encode($data);
        
            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];
        
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }        
            // Close connection
            curl_close($ch);
            // FCM response

            $data = json_decode($result, true);

            $multicast_id = $data['multicast_id'];
            $message_id = $data['results'][0]['message_id'];

            $Notification = new Notification();
            $Notification->multicast_id = $multicast_id;
            $Notification->message_id = $message_id;
            $Notification->added_by = Auth::user()->id;
            $Notification->save();

            return redirect()->to("/home")->with('status','Sent Notification.'); 
            
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        
    }
}

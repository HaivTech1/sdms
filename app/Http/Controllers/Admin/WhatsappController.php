<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Student;
use App\Traits\CurlRequestTrait;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class WhatsappController extends Controller
{
    use CurlRequestTrait;
    
    public $per_page = 20;
    public $contacts;
    public $messages;

    public function contacts()
    {
        $title = "Contacts";
        $description = "All bot contacts";
        $response = $this->getRequest(env('IMPRESSION_URL')."/api/contact/all");
        $contacts = collect($response ? $response: []);
        $currentPage = request()->input('page', 1);
        $this->contacts = count($contacts) > 0 ? new LengthAwarePaginator(
            $contacts->forPage($currentPage, $this->per_page),
            $contacts->count(),
            $this->per_page,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        ) : [];

        return view('admin.whatsapp.contact', [
            'title' => $title,
            'description' => $description,
            'contacts' => $this->contacts,
        ]);
    }

    public function storeContact(Request $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'type' => $request->type,
            ];
            $response = $this->postRequest(env('IMPRESSION_URL')."/api/contact/store", $data);
            info($response);
            return response()->json([
                'status' => $response['status'],
                'message' => $response['message'],
            ], 200);
        } catch (\Throwable $th) {
            info("Contact creation Error: " . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => "There was an error creating the contact",
            ], 500);
        }
    }

    public function messages()
    {
        $title = "Messages";
        $description = "All bot sent messages";
        $response = $this->getRequest(env('IMPRESSION_URL')."/api/message/sent/messages");
        $messages = collect($response ? $response['data'] : []);
        $currentPage = request()->input('page', 1);
        $this->messages = count($messages) > 0 ? new LengthAwarePaginator(
            $messages->forPage($currentPage, $this->per_page),
            $messages->count(),
            $this->per_page,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        ) : [];

        return view('admin.whatsapp.sentMessage', [
            'title' => $title,
            'description' => $description,
            'messages' => $this->messages,
        ]);
    }

    public function sendMessage(Request $request)
    {
        try {
            sendWaMessage($request->phone_number, $request->message);
            return response()->json([
                'status' => true,
                'message' => "Message sent Successfully!",
            ], 200);
        } catch (\Throwable $th) {
            info("Message Sending Error: " . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'There was an error sending the message. Please try again',
            ], 500);
        }
    }

    public function sendMultipleMessage(Request $request)
    {
        try {

            $ids = $request->ids;
            $message = $request->message;
            $action = $request->action;

            $batchSize = 50; 
            $chunks = array_chunk($ids, $batchSize);

            if($action === "broadcast"){
                foreach ($chunks as $batch) {
                    foreach ($batch as $contact) {
                        $phoneNumber = $contact;

                        if (isValidPhoneNumber($phoneNumber)) {
                            sendWaMessage($phoneNumber, $message);
                        }
                    }

                    sleep(5); 
                }
            }
            
            return response()->json([
                'status' => true,
                'message' => "Message sent Successfully!",
            ], 200);

        } catch (\Throwable $th) {
            info("Message Sending Error: " . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'There was an error sending the message. Please try again',
            ], 500);
        }
    }

    public function mergeParentContact($type)
    {
        try {
            if($type === 'mother'){
                $contacts = Mother::all();
            }else{
                $contacts = Father::all();
            }

            $parent_contacts = [];
            foreach ($contacts as $contact) {
                $parent_contacts[] = [
                    'name' => $contact->name,
                    'phone_number' => $contact->phone ?? null,
                ];
            }

            return response()->json([
                'status' => true,
                'data' => $parent_contacts
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "There was an error merging contacts"
            ], 500);
        }
    }

    public function createMultipleContacts(Request $request)
    {
        try {
            $selectedContacts = $request->json()->all();

            foreach ($selectedContacts as $contact) {
                $data = [
                    'name' => $contact['name'],
                    'phone_number' => $contact['phone_number'],
                    'type' => 'default',
                ];
                $response = $this->postRequest(env('IMPRESSION_URL')."/api/contact/store", $data);
            }
            return response()->json([
                'status' => $response['status'],
                'message' => $response['message'],
            ], 200);
        } catch (\Throwable $th) {
            info("Contact creation Error: " . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => "There was an error creating the contact",
            ], 500);
        }
    }


    public function scheduleMessage(Request $request)
    {
        try {
            if (is_array($request->contacts)) {
                $contacts = $request->contacts;
            }else{
                $contacts = explode(',', $request->contacts);
            }

            $data = [
                'from' => $request->from,
                'to' => $request->to,
                'time' => $request->time,
                'message' => $request->message,
                'method' => $request->method,
                'contacts' => $contacts,
                'type' => 'default',
                'sender' => env('IMPRESSION_SENDER', '09066100815')
            ];

            $response = $this->postRequest(env('IMPRESSION_URL')."/api/schedule/store", $data);

            return response()->json([
                'status' => true,
                'message' => "Message scheduled Successfully!",
            ], 200);

        } catch (\Throwable $th) {
            info("Message Sending Error: " . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'There was an error sending the message. Please try again',
            ], 500);
        }
    }
}

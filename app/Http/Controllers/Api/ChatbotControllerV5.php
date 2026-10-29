<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatbotMessage;
use App\Models\ChatbotSession;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\ChatbotFaq;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ChatbotControllerV5 extends Controller
{
    private $apiKey;
    private $assistantId;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
        $this->assistantId = env('OPENAI_ASSISTANT_ID');
    }

    /**
     * Create OpenAI Thread
     */
    // public function createThread(Request $request)
    // {
    //     try {

    //         $response = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . $this->apiKey,
    //             'OpenAI-Beta' => 'assistants=v2'
    //         ])->post('https://api.openai.com/v1/threads');

    //         if (!$response->successful()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Thread creation failed'
    //             ], 500);
    //         }

    //         $threadId = $response['id'];

    //         ChatbotSession::firstOrCreate([
    //             'thread_id' => $threadId,
    //             'client' => "VRC",
    //             'ip_address' => $request->ip(),
    //             'user_agent' => $request->userAgent(),
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'thread_id' => $threadId
    //         ]);

    //     } catch (\Exception $e) {

    //         return response()->json([
    //             'success' => false,
    //             'message' => $e->getMessage()
    //         ], 500);

    //     }
    // }
    
    public function createThread(Request $request)
    {
        try {
            $threadId = (string) Str::uuid();
            ChatbotSession::firstOrCreate([
                'thread_id' => $threadId,
                'client' => "VRC",
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return response()->json([
                'success' => true,
                'thread_id' => $threadId
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    /**
     * Save contact details submitted from the chatbot.
     */
    public function sendContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:100',
            'address' => 'nullable|string|max:300',
            'email' => 'nullable|email|max:100',
            // 'contact' => 'required|string|max:50',
            'contact' => 'required|string|regex:/^\+?[0-9\s\-()]{7,20}$/',
            'budget' => 'nullable|string|max:100',
            'requirement' => 'nullable|string|max:500',
            'message' => 'nullable|string|max:800',
            'thread_id' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->first(),
            ], 422);
        }

        try {
            $contact = Contact::create($validator->validated());
            return response()->json([
                'success' => true,
                'message' => 'Contact details submitted successfully',
                'data' => $contact,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Send Message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'thread_id' => 'required',
            'message' => 'required|string'
        ]);

        try {

            $threadId = $request->thread_id;
            $message = $request->message;

            $session = ChatbotSession::firstOrCreate([
                'thread_id' => $threadId,
                'client' => "VRC",
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);


            $message = strtolower(trim($request->message));
            $faqs = ChatbotFaq::where('status',1)->get();

            ChatbotMessage::create([
                'chatbot_session_id' => $session->id,
                'role' => 'user',
                'content' => $message,
                'external_id' =>  null,
            ]);

            foreach($faqs as $faq)
            {
                $keywords = explode(',', strtolower($faq->keywords));

                foreach($keywords as $keyword)
                {
                    if(str_contains($message, trim($keyword)))
                    {
                        ChatbotMessage::create([
                            'chatbot_session_id' => $session->id,
                            'role' => 'assistant',
                            'content' => $faq->answer,
                            'external_id' => null,
                        ]);

                        return response()->json([
                            'success' => true,
                            'reply' => json_decode($faq->answer, true),
                            'thread_id' => $threadId,
                            'session_id' => $session->id,
                        ]);
                    }
                }
            }

            $fallbackReply = [
                'text' => "I want to make sure I give you the most accurate advice regarding \"{$message}\". Could you please mention your area of interest explore our technical capabilities, review our past work, or discuss your upcoming project requirements with our experts.",
                'link' => [
                    'label' => "🔗 🛠️ Our Services",
                    'url' => "https://vrwebconsulting.com/"
                ],
                'suggestions' => [
                    "Our Services",
                    "Software Products",
                    'SEO Sevices',
                    "Portfolio",
                    "Request a Quote",
                    "Contact Details"
                ],
                'source' => "local"
            ];

            ChatbotMessage::create([
                'chatbot_session_id' => $session->id,
                'role' => 'assistant',
                'content' => json_encode($fallbackReply, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'external_id' => null,
            ]);

            return response()->json([
                'success' => true,
                'reply' => $fallbackReply,
                'thread_id' => $threadId,
                'session_id' => $session->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // /**
    //  * Send Message
    //  */
    // public function sendMessage(Request $request)
    // {
    //     $request->validate([
    //         'thread_id' => 'required',
    //         'message' => 'required|string'
    //     ]);

    //     try {

    //         $threadId = $request->thread_id;
    //         $message = $request->message;

    //         $session = ChatbotSession::firstOrCreate([
    //             'thread_id' => $threadId,
    //             'client' => "VRC",
    //             'ip_address' => $request->ip(),
    //             'user_agent' => $request->userAgent(),
    //         ]);

    //         /*
    //         |--------------------------------------------------------------------------
    //         | Add User Message
    //         |--------------------------------------------------------------------------
    //         */

    //         $userMessageResponse = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . $this->apiKey,
    //             'OpenAI-Beta' => 'assistants=v2'
    //         ])->post(
    //             "https://api.openai.com/v1/threads/{$threadId}/messages",
    //             [
    //                 'role' => 'user',
    //                 'content' => $message
    //             ]
    //         );

    //         if (!$userMessageResponse->successful()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Failed to add user message',
    //                 'status' => $userMessageResponse->status(),
    //                 'error' => $userMessageResponse->json(),
    //             ], 500);
    //         }

    //         ChatbotMessage::create([
    //             'chatbot_session_id' => $session->id,
    //             'role' => 'user',
    //             'content' => $message,
    //             'external_id' => $userMessageResponse['id'] ?? null,
    //         ]);

    //         /*
    //         |--------------------------------------------------------------------------
    //         | Run Assistant
    //         |--------------------------------------------------------------------------
    //         */

    //         $runResponse = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . $this->apiKey,
    //             'OpenAI-Beta' => 'assistants=v2'
    //         ])->post(
    //             "https://api.openai.com/v1/threads/{$threadId}/runs",
    //             [
    //                 'assistant_id' => $this->assistantId
    //             ]
    //         );

    //         if (!$runResponse->successful()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'status' => $runResponse->status(),
    //                 'error' => $runResponse->json()
    //             ], 500);
    //         }

    //         $runId = $runResponse['id'];
    //         $status = '';

    //         for ($i = 0; $i < 20; $i++) {
    //             sleep(1);

    //             $runCheck = Http::withHeaders([
    //                 'Authorization' => 'Bearer ' . $this->apiKey,
    //                 'OpenAI-Beta' => 'assistants=v2'
    //             ])->get(
    //                 "https://api.openai.com/v1/threads/{$threadId}/runs/{$runId}"
    //             );

    //             $status = $runCheck['status'];

    //             if ($status === 'completed') {
    //                 break;
    //             }

    //             if (
    //                 $status === 'failed' ||
    //                 $status === 'cancelled' ||
    //                 $status === 'expired'
    //             ) {
    //                 return response()->json([
    //                     'success' => false,
    //                     'status' => $status,
    //                     'run_error' => $runCheck->json()
    //                 ], 500);
    //             }
    //         }

    //         /*
    //         |--------------------------------------------------------------------------
    //         | Get Messages
    //         |--------------------------------------------------------------------------
    //         */

    //         $messages = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . $this->apiKey,
    //             'OpenAI-Beta' => 'assistants=v2'
    //         ])->get(
    //             "https://api.openai.com/v1/threads/{$threadId}/messages"
    //         );

    //         $assistantMessage = '';
    //         $assistantExternalId = null;

    //         foreach ($messages['data'] as $msg) {
    //             if ($msg['role'] === 'assistant') {
    //                 $assistantMessage = $msg['content'][0]['text']['value'] ?? '';
    //                 $assistantExternalId = $msg['id'] ?? null;
    //                 $assistantMessage = preg_replace('/【.*?】/u', '', $assistantMessage);
    //                 $assistantMessage = trim($assistantMessage);
    //                 break;
    //             }
    //         }

    //         if ($assistantMessage !== '') {
    //             ChatbotMessage::create([
    //                 'chatbot_session_id' => $session->id,
    //                 'role' => 'assistant',
    //                 'content' => $assistantMessage,
    //                 'external_id' => $assistantExternalId,
    //             ]);
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'reply' => $assistantMessage,
    //             'thread_id' => $threadId,
    //             'session_id' => $session->id,
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }


    


}
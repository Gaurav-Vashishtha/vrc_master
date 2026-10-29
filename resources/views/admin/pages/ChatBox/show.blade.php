@extends('admin.template.base')

@section('title','Chat Session Details')

@section('styles')
    <style>
        .chat-suggestion-btn {
            color: rgb(55, 48, 163);
            padding: 3px 5px;
            border-width: 1px;
            border-style: solid;
            border-color: rgb(199, 210, 254);
            border-radius: 8px;
            background: rgb(238, 242, 255);
            font-size: 12px;

        }
    </style>
@endsection

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">
            <h4>Chat Session Details</h4>
        </div>

        <div class="card-body">

            <a href="{{ route('admin.chatbox.index') }}" class="btn btn-secondary">
                Back
            </a>

            <table class="table table-bordered">

                <tr>
                    <th>ID</th>
                    <td>{{ $chatSession->id }}</td>
                </tr>

                <tr>
                    <th>Thread ID</th>
                    <td>{{ $chatSession->thread_id }}</td>
                </tr>

                <tr>
                    <th>Client</th>
                    <td>{{ $chatSession->client }}</td>
                </tr>

                <tr>
                    <th>IP Address</th>
                    <td>{{ $chatSession->ip_address }}</td>
                </tr>

                <tr>
                    <th>User Agent</th>
                    <td>{{ $chatSession->user_agent }}</td>
                </tr>

                <tr>
                    <th>Created At</th>
                    <td>{{ $chatSession->created_at }}</td>
                    <td>

                        <form action="{{ route('admin.chatbox.pin',$chatSession->id) }}"
                            method="POST">

                            @csrf

                            <button type="submit"
                                style="border:none;background:none;cursor:pointer;">

                                @if($chatSession->is_pinned)

                                <i class="mdi mdi-pin"
                                    style="color:red;font-size:20px"
                                    title="Unpin"></i>

                                @else

                                <i class="mdi mdi-pin-outline"
                                    style="font-size:20px;color: blueviolet;"
                                    title="Pin"></i>

                                @endif

                            </button>

                        </form>

                    </td>
                </tr>

            </table>

            <h4>Messages</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Content</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                @forelse($chatSession->messages as $message)
                @php
                    $decodedContent = json_decode($message->content, true);
                    $content = json_last_error() === JSON_ERROR_NONE && is_string($decodedContent)
                        ? $decodedContent
                        : $message->content;
                    $isStructuredReply = is_array($decodedContent);
                @endphp
                <tr>
                    <td style="white-space: normal;">{{ $message->role }}</td>
                    <td style="white-space: normal;">
                        @if ($isStructuredReply)
                            @if (!empty($decodedContent['text']))
                                {!! \Illuminate\Support\Str::markdown((string) $decodedContent['text']) !!}
                            @endif

                            @php
                                $linkUrl = $decodedContent['link']['url'] ?? null;
                                $linkScheme = is_string($linkUrl) ? parse_url($linkUrl, PHP_URL_SCHEME) : null;
                            @endphp
                            @if (!empty($decodedContent['link']['label']) && in_array(strtolower((string) $linkScheme), ['http', 'https'], true))
                                <div class="chat-link-wrapper">
                                    <a href="{{ $linkUrl }}" class="chat-link-btn" target="_blank" rel="noopener noreferrer">
                                        {{ $decodedContent['link']['label'] }}
                                    </a>
                                </div>
                            @endif

                            @if (!empty($decodedContent['suggestions']) && is_array($decodedContent['suggestions']))
                                <div class="chat-suggestions">
                                    @foreach ($decodedContent['suggestions'] as $suggestion)
                                        @if (is_scalar($suggestion))
                                            <button type="button" class="chat-suggestion-btn" disabled>{{ $suggestion }}</button>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        @else
                            {!! \Illuminate\Support\Str::markdown((string) $content) !!}
                        @endif
                    </td>
                    <td style="white-space: normal;">{{ $message->created_at }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">No messages found.</td>
                </tr>
                @endforelse
            </table>

        </div>

    </div>

</div>

@endsection
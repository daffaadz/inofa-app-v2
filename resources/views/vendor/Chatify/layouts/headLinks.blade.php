<title>{{ config('chatify.name') }}</title>

{{-- Meta tags --}}
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="id" content="{{ $id }}">
<meta name="messenger-color" content="{{ $messengerColor }}">
<meta name="messenger-theme" content="{{ $dark_mode }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="url" content="{{ url('').'/'.config('chatify.routes.prefix') }}" data-user="{{ Auth::user()->id }}">

{{-- scripts --}}
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/chatify/font.awesome.min.js') }}"></script>
<script src="{{ asset('js/chatify/autosize.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>

{{-- styles --}}
<link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css'/>
<link href="{{ asset('css/chatify/style.css') }}" rel="stylesheet" />
<link href="{{ asset('css/chatify/'.$dark_mode.'.mode.css') }}" rel="stylesheet" />
<link href="{{ asset('css/app.css') }}" rel="stylesheet" />

{{-- Setting messenger primary color to css --}}
<style>
    :root {
        --primary-color: {{ $messengerColor }};
    }

    /* CSS PROPOSAL CARD */
    .proposal-message { margin: 15px 10px; }
    .proposal-message .card { max-width: 500px; border-radius: 12px; overflow: hidden; }
    .proposal-message.owner .card { margin-left: auto; }
    .proposal-message.client .card { margin-right: auto; }
    .proposal-message .icon-wrapper { width: 35px; height: 35px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; }
    .proposal-message .card-header { font-size: 14px; }
    .proposal-message .alert { font-size: 13px; padding: 10px 12px; margin-bottom: 10px; }
    .proposal-message .btn { font-size: 14px; font-weight: 500; }
    .proposal-message .text-sm { font-size: 0.875rem; }
</style>

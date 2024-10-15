
    <strong>{{ $messageData->user->name }}</strong>:
    <p>{{ $messageData->message }}</p>
    @if ($messageData->media_path)
        <img src="{{ asset('storage/' . $messageData->media_path) }}" alt="User upload" class="img-fluid mt-2" />
    @endif
    <small class="text-muted">{{ $messageData->created_at->diffForHumans() }}</small>

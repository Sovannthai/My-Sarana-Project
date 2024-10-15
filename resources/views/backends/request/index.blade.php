@extends('backends.master')
<style>
    .chat-body {
        max-height: 400px;
        overflow-y: auto;
        padding: 10px;
        background-color: #f5f5f5;
        border-radius: 10px;
    }

    .message {
        margin-bottom: 15px;
        display: flex;
        align-items: flex-start;
        /* max-width: 80%; */
    }

    .message.received {
        justify-content: flex-start;
    }

    .message.sent {
        justify-content: flex-end;
    }

    .message-content {
        background-color: #e4e6eb;
        padding: 10px;
        border-radius: 20px;
        position: relative;
        font-size: 14px;
        line-height: 1.4;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .message.received .message-content {
        background-color: #ffffff;
        border: 1px solid #ddd;
    }

    .message.sent .message-content {
        background-color: #0084ff;
        color: white;
    }

    .message-content:before {
        content: '';
        position: absolute;
        top: 0;
        width: 0;
        height: 0;
    }

    .message.received .message-content:before {
        left: -10px;
        border-width: 10px;
        border-style: solid;
        border-color: transparent #ffffff transparent transparent;
    }

    .message.sent .message-content:before {
        right: -10px;
        border-width: 10px;
        border-style: solid;
        border-color: transparent transparent transparent #0084ff;
    }

    /* Profile Picture */
    .profile-pic {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .message.sent .profile-pic {
        margin-left: 10px;
        margin-right: 0;
    }

    /* Username */
    .username {
        font-weight: bold;
        font-size: 12px;
        display: block;
        margin-bottom: 5px;
    }

    /* Scrollable modal body */
    .modal-body {
        max-height: 400px;
        overflow-y: auto;
        padding: 15px;
        background-color: #f9f9f9;
    }

    /* Footer form styles */
    .modal-footer form {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .modal-footer textarea {
        flex-grow: 1;
        border-radius: 20px;
        padding-left: 15px;
        resize: none;
    }

    .modal-footer .input-group-text {
        border: none;
        background-color: transparent;
        cursor: pointer;
    }

    .modal-footer .btn-primary {
        border-radius: 50%;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-footer .btn-primary i {
        font-size: 18px;
    }

    /* Adjust textarea for better appearance */
    .input-group textarea {
        resize: none;
        border-radius: 20px;
        padding-left: 15px;
    }

    /* Input group icon adjustments */
    .input-group-text {
        border: none;
        background-color: transparent;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    /* Send button with icon */
    .btn-primary {
        border-radius: 50%;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-primary i {
        font-size: 18px;
    }
</style>
@section('contents')
    <div class="card">
        <div class="card-header text-uppercase">
            <h5>List Request</h5>
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_requests as $row)
                        <tr>
                            <td>
                                <a class="example-image-link" href="{{ $row->avatar }}"
                                    data-lightbox="lightbox-{{ $row->user_id }}">
                                    <img src="{{ $row->avatar }}" alt="profile" width="50px" height="50px"
                                        class="image-thumbnail" />
                                </a>
                            </td>
                            <td>{{ $row->name }}</td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm open-chat" data-user-id="{{ $row->user_id }}"
                                    data-bs-toggle="modal" data-bs-target="#view_message-{{ $row->user_id }}">
                                    Chat <span class="badge badge-danger">4</span>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal for Chat -->
                        <div class="modal fade" id="view_message-{{ $row->user_id }}" tabindex="-1"
                            aria-labelledby="chatModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <!-- Modal Header with User Profile -->
                                    <div class="modal-header d-flex align-items-center">
                                        <a class="example-image-link" href="{{ $row->avatar }}"
                                            data-lightbox="lightbox-{{ $row->user_id }}">
                                            <img src="{{ $row->avatar }}" alt="profile" width="50px" height="50px"
                                                class="rounded-circle me-3" />
                                        </a>
                                        <h5 class="modal-title">Chat with {{ $row->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <!-- Chat Messages -->
                                    <div class="modal-body chat-body" style="max-height: 550px; overflow-y: auto;">
                                        <div class="messages-container" id="messages-{{ $row->user_id }}">
                                            <!-- Messages will be loaded here via AJAX -->
                                        </div>
                                    </div>
                                    <!-- Message Input -->
                                    <div class="modal-footer">
                                        <form id="messageForm-{{ $row->user_id }}" class="w-100"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group">
                                                <div id="imagePreview-{{ $row->user_id }}" class="image-preview"
                                                    style="margin-bottom: 10px;"></div> <!-- Image Preview Container -->
                                                <textarea name="message" class="form-control" placeholder="Type a message..." rows="1"></textarea>
                                                <label class="input-group-text" for="fileInput-{{ $row->user_id }}">
                                                    <i class="fas fa-paperclip"></i>
                                                </label>
                                                <input type="file" class="d-none" id="fileInput-{{ $row->user_id }}"
                                                    name="media_part"
                                                    accept=".pdf, .doc, .docx, .xls, .xlsx, .jpg, .jpeg, .png">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        //Show chat conversations
        $(document).on('click', '.open-chat', function() {
            let telegramId = $(this).data('user-id');
            let messagesContainer = $('#messages-' + telegramId);
            messagesContainer.empty();

            let messagesUrl = `{{ route('fetch.messages', ':telegramId') }}`.replace(':telegramId', telegramId);
            $.ajax({
                url: messagesUrl,
                method: 'GET',
                success: function(messages) {
                    if (messages.length > 0) {
                        messages.forEach(message => {
                            let messageHtml = '';
                            const createdAt = new Date(message.created_at).toLocaleString();
                            if (message.message && message.media_path) {
                                if (message.message.trim().toLowerCase() === "photo received") {
                                    // Show only the media
                                    messageHtml = `
                                <div class="message ${message.sender_type}">
                                    <div class="message-content">
                                        <a href="${message.media_path}" data-lightbox="lightbox-${message.id}">
                                            <img src="${message.media_path}" alt="Photo" class="img-fluid"
                                                 style="width: auto; height: 15rem;" />
                                        </a>
                                    </div>
                                    <small>${createdAt}</small> <!-- Show created_at below media -->
                                </div>`;
                                } else {
                                    // Show both media and message
                                    messageHtml = `
                                <div class="message ${message.sender_type}">
                                    <div class="message-content">
                                        <a href="${message.media_path}" data-lightbox="lightbox-${message.id}">
                                            <img src="${message.media_path}" alt="Photo" class="img-fluid"
                                                 style="width: auto; height: 15rem;" />
                                        </a>
                                        <p>${message.message}</p>
                                    </div>
                                    <small>${createdAt}</small> <!-- Show created_at below message -->
                                </div>`;
                                }
                            } else if (message.message) {
                                // Case: Only the message is present
                                messageHtml = `
                            <div class="message ${message.sender_type}">
                                <div class="message-content">
                                    ${message.message}
                                </div>
                                <small>${createdAt}</small> <!-- Show created_at below message -->
                            </div>`;
                            } else if (message.media_path) {
                                // Case: Only the media is present
                                messageHtml = `
                            <div class="message ${message.sender_type}">
                                <div class="message-content">
                                    <a href="${message.media_path}" data-lightbox="lightbox-${message.id}">
                                        <img src="${message.media_path}" alt="Photo" class="img-fluid"
                                             style="width: auto; height: 15rem;" />
                                    </a>
                                </div>
                                <small>${createdAt}</small> <!-- Show created_at below media -->
                            </div>`;
                            }

                            messagesContainer.append(messageHtml);
                        });
                    } else {
                        messagesContainer.html('<p>No messages found.</p>');
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching messages:', xhr);
                    messagesContainer.html('<p>Error loading messages.</p>');
                }
            });
        });
        //Reply Meessage
        $(document).ready(function() {
            $('#fileInput-{{ $row->user_id }}').on('change', function() {
                const file = this.files[0];
                const textarea = $('textarea[name="message"]');
                const previewContainer = $(
                    '#imagePreview-{{ $row->user_id }}');
                textarea.val('');
                previewContainer.empty();

                if (file) {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        // Display image preview
                        reader.onload = function(e) {
                            const imgElement =
                                `<img src="${e.target.result}" alt="Image Preview" style="max-width: 10%; border-radius: 12px;" />`;
                            previewContainer.append(imgElement);
                        };

                        reader.readAsDataURL(file);
                    } else {
                        textarea.val(file.name);
                    }
                }
            });
            $('#messageForm-{{ $row->user_id }}').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const userId = "{{ $row->user_id }}";

                // Append the userId to formData
                formData.append('user_id', userId);

                $.ajax({
                    url: '{{ route('send-message.send') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('textarea[name="message"]').val('');
                        $('#imagePreview-{{ $row->user_id }}')
                            .empty();

                        let messageContent;

                        // Check if the response contains an image URL
                        if (response.media_url) {
                            messageContent = `
                        <div class="message sent">
                            <div class="message-content">
                                <img src="${response.media_url}" alt="Image" style="max-width: 10%; border-radius: 12px;" />
                            </div>
                        </div>
                    `;
                        } else {
                            messageContent = `
                        <div class="message sent">
                            <div class="message-content">
                                <span style="font-weight: bold;">You:</span> ${response.message}
                            </div>
                        </div>
                    `;
                        }
                        $('#messages-' + userId).append(messageContent);
                        $('#messages-' + userId).scrollTop($('#messages-' + userId)[0]
                            .scrollHeight);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error sending message:', error);
                    }
                });
            });
        });
        //Store meesage form bot
        $(document).ready(function() {
            function fetchMessages() {
                $.ajax({
                    url: '{{ route('get-chat-from-user') }}',
                    method: 'GET',
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
            setInterval(fetchMessages, 2000);
        });
    </script>
@endsection

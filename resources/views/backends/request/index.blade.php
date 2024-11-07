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
        background-color: #eaf0f5;
        /* color: white; */
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
        border-color: transparent transparent transparent #eaf0f5;
    }

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

    .username {
        font-weight: bold;
        font-size: 12px;
        display: block;
        margin-bottom: 5px;
    }

    .modal-body {
        max-height: 400px;
        overflow-y: auto;
        padding: 15px;
        background-color: #f9f9f9;
    }

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

    .input-group textarea {
        resize: none;
        border-radius: 20px;
        padding-left: 15px;
    }

    .input-group-text {
        border: none;
        background-color: transparent;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

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

    .date-header {
        text-align: center;
        margin: 10px 0;
        font-weight: bold;
        color: #888;
        font-size: 0.9rem;
        padding: 5px 10px;
        border-radius: 12px;
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
                                    data-lightbox="lightbox-{{ $row->telegram_id }}">
                                    <img src="{{ $row->avatar }}" alt="profile" width="50px" height="50px"
                                        class="image-thumbnail" />
                                </a>
                            </td>
                            <td>{{ $row->name }}</td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm open-chat"
                                    data-user-id="{{ $row->telegram_id }}" data-bs-toggle="modal"
                                    data-bs-target="#view_message-{{ $row->telegram_id }}">
                                    Chat
                                    <span class="badge badge-danger">{{ $row->unread_messages_count }}</span>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal for Chat -->
                        <div class="modal fade" id="view_message-{{ $row->telegram_id }}" tabindex="-1"
                            aria-labelledby="chatModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header d-flex align-items-center">
                                        <a class="example-image-link" href="{{ $row->avatar }}"
                                            data-lightbox="lightbox-{{ $row->telegram_id }}">
                                            <img src="{{ $row->avatar }}" alt="profile" width="50px" height="50px"
                                                class="rounded-circle me-3" />
                                        </a>
                                        <h5 class="modal-title">Chat with {{ $row->name }}</h5>
                                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button> --}}
                                        <a href="{{ route('user-request.index') }}" class="btn-close"></a>
                                    </div>
                                    <div class="modal-body chat-body"
                                        style="max-height: 550px; overflow-y: auto; background-color: #e0e0e0; border-radius: 0px;">
                                        <div class="messages-container" id="messages-{{ $row->telegram_id }}">
                                            <!-- Messages will be loaded here via AJAX -->
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <form id="messageForm-{{ $row->telegram_id }}" class="w-100"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group">
                                                <div id="imagePreview-{{ $row->telegram_id }}" class="image-preview"
                                                    style="margin-bottom: 10px;"></div>
                                                <textarea name="message" class="form-control message-text" placeholder="Type a message..." rows="1"></textarea>
                                                <label class="input-group-text" for="fileInput-{{ $row->telegram_id }}">
                                                    <i class="fas fa-paperclip"></i>
                                                </label>
                                                <input type="file" class="d-none fileInput"
                                                    id="fileInput-{{ $row->telegram_id }}" name="media_part"
                                                    accept=".pdf, .doc, .docx, .xls, .xlsx, .jpg, .jpeg, .png">
                                                <button type="button" class="btn btn-primary submit-form">
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
            console.log(telegramId);
            let messagesContainer = $('#messages-' + telegramId);
            messagesContainer.empty();

            let messagesUrl = `{{ route('fetch.messages', ':telegramId') }}`.replace(':telegramId', telegramId);

            // Fetch messages via AJAX
            $.ajax({
                url: messagesUrl,
                method: 'GET',
                success: function(messages) {
                    if (messages.length > 0) {
                        let groupedMessages = groupMessagesByDate(messages);

                        // Append grouped messages to the container
                        for (const [date, msgs] of Object.entries(groupedMessages)) {
                            messagesContainer.append(`<div class="date-header">${date}</div>`);

                            msgs.forEach(message => {
                                let messageHtml = '';
                                const messageTime = new Date(message.created_at)
                                    .toLocaleTimeString('en-US', {
                                        hour: '2-digit',
                                        minute: '2-digit',
                                        hour12: true
                                    });

                                let isDownloadable = /\.(pdf|doc|docx|xls|xlsx)$/i.test(message
                                    .media_path);
                                let isVideo = /\.(mp4|webm|MOV)$/i.test(message.media_path);

                                if (isVideo) {
                                    messageHtml = generateVideoHTML(message);
                                } else if ((message.message && message.message.trim()
                                        .toLowerCase() === "photo received") ||
                                    (message.message && message.message.trim().toLowerCase() ===
                                        "sticker received")) {
                                    messageHtml = generateMediaHTML(message, isDownloadable,
                                        messageTime);
                                } else if (message.message && message.media_path) {
                                    messageHtml = `
                            <div class="message ${message.sender_type}">
                                <div class="message-content">
                                    ${generateMediaHTML(message, isDownloadable, messageTime)}
                                    <p>${message.message}</p>
                                </div>
                                <small>${messageTime}</small>
                            </div>`;
                                } else if (message.media_path) {
                                    messageHtml = generateMediaHTML(message, isDownloadable,
                                        messageTime);
                                } else if (message.message) {
                                    messageHtml = `
                            <div class="message ${message.sender_type}">
                                <div class="message-content">${message.message}</div>
                                <small>${messageTime}</small>
                            </div>`;
                                }

                                messagesContainer.append(messageHtml);
                            });
                        }

                        setTimeout(function() {
                            $('.chat-body').animate({
                                scrollTop: messagesContainer[0].scrollHeight
                            });
                        }, 100);

                    } else {
                        messagesContainer.html('<p>No messages found.</p>');
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching messages:', xhr);
                    messagesContainer.html('<p>Error loading messages.</p>');
                }
            });

            $('#view_message-' + telegramId).modal('show');
        });
        // Helper function to group messages by date
        function groupMessagesByDate(messages) {
            return messages.reduce((groups, message) => {
                const date = new Date(message.created_at).toLocaleDateString('en-US', {
                    month: '2-digit',
                    day: '2-digit',
                    year: 'numeric',
                });

                if (!groups[date]) {
                    groups[date] = [];
                }
                groups[date].push(message);
                return groups;
            }, {});
        }

        function generateVideoHTML(message) {
            const fileExtension = message.media_path.split('.').pop().toLowerCase();
            const shouldAutoplay = fileExtension === 'webm' || fileExtension === 'webp';
            const mimeType = getMimeType(fileExtension); // New helper function to get MIME type

            return `
    <div class="message ${message.sender_type}">
        <video ${shouldAutoplay ? 'autoplay loop' : ''} controls style="width: auto; height: 15rem;">
            <source src="${message.media_path}" type="${mimeType}">
            Your browser does not support the video tag.
        </video>
    </div>`;
        }

        // Helper function to get the MIME type based on file extension
        function getMimeType(extension) {
            switch (extension) {
                case 'mp4':
                    return 'video/mp4';
                case 'MOV':
                    return 'video/quicktime';
                case 'webm':
                    return 'video/webm';
                case 'webp':
                    return 'image/webp';
                default:
                    return 'video/mp4';
            }
        }
        // Helper function to generate HTML for media content
        function generateMediaHTML(message, isDownloadable, messageTime) {
            if (isDownloadable) {
                return `
        <div class="message ${message.sender_type}">
            <div class="message-content">
                <a href="${message.media_path}" download class="btn btn-primary">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
            <small>${messageTime}</small>
        </div>`;
            } else {
                return `
        <div class="message ${message.sender_type}">
            <div class="message-content">
                <a href="${message.media_path}" data-lightbox="lightbox-${message.id}">
                    <img src="${message.media_path}" alt="Media" class="img-fluid"
                         style="width: auto; height: 15rem;" />
                </a>
            </div>
            <small>${messageTime}</small>
        </div>`;
            }
        }

        // Helper function to get the filename from the media path
        function getFileName(path) {
            return path.split('/').pop();
        }

        //Reply Meessage
        $(document).ready(function() {
            $('.fileInput').on('change', function() {
                const file = this.files[0];
                const previewContainer = $(this).closest('.input-group').find('.imagePreview');
                const textarea = $(this).closest('.input-group').find('textarea');

                previewContainer.empty();
                textarea.val('');

                if (file) {
                    const validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                    if (validImageTypes.includes(file.type)) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const imgElement = `
                        <img src="${e.target.result}" alt="Image Preview"
                             style="max-width: 10%; border-radius: 12px;" />
                    `;
                            previewContainer.append(imgElement);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        textarea.val(file.name);
                    }
                }
            });

            $('.submit-form').on('click', function(e) {
                e.preventDefault();

                const userId = $(this).closest('.modal').attr('id').split('-').pop();
                const fileInput = $(this).closest('.input-group').find('.fileInput')[0];
                const file = fileInput ? fileInput.files[0] : null;
                const message = $(this).closest('.input-group').find('textarea').val();
                const previewContainer = $(this).closest('.input-group').find('.imagePreview');

                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('_method', 'POST');
                formData.append('user_id', userId);
                formData.append('message', message);
                if (file) {
                    formData.append('media_part', file);
                }

                if (!file && message === "") {
                    toastr.warning('Please enter a message or select a file.', 'Warning');
                    return;
                }

                $.ajax({
                    url: '{{ route('send-message.send') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('textarea[name="message"]').val('');
                        fileInput.value = '';
                        previewContainer.empty();

                        let messageContent = '';

                        if (response.media_url) {
                            messageContent = `
                        <div class="message sent">
                            <div class="message-content">
                                <img src="${response.media_url}" alt="Image"
                                     style="max-width: 10%; border-radius: 12px;" />
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
                        toastr.success('Message sent successfully!', 'Success');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error sending message:', error);
                        toastr.error('Failed to send message. Please try again.', 'Error');
                    }
                });
            });
        });
    </script>
@endsection

@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Chat Box</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Chat Box</div>
            </div>
        </div>

        <div class="section-body">


            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card" style="height: 70vh">
                        <div class="card-header">
                            <h4>Who's Online?</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">

                                @foreach($senders as $sender)

                                    @php
                                        $chatUser = \App\Models\User::find($sender->sender_id);
                                        $unseenMessages = \App\Models\Chat::where(['sender_id' => $chatUser->id, 'receiver_id' => auth()->user()->id, 'seen' => 0])->count();
                                    @endphp

                                    <li class="media fp_chat_user" data-name="{{$chatUser->name}}"
                                        data-user="{{ $chatUser->id }}" style="cursor: pointer">
                                        <img alt="image" class="mr-3 rounded-circle" width="50"
                                             src="{{ asset($chatUser->avatar) }}"
                                             style="width: 50px;height: 50px; object-fit: cover;">
                                        <div class="media-body">
                                            <div class="mt-0 mb-1 font-weight-bold"
                                                 id="user-name-{{$chatUser->id}}">{{ $chatUser->name }}</div>
                                            <div class="text-warning text-small font-600-bold got_new_message">
                                                @if ($unseenMessages > 0)
                                                    <i class="beep"></i>new message
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach


                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-9">
                    <div class="card chat-box" id="mychatbox" data-inbox="" style="height: 70vh">
                        <div class="card-header">
                            <h4 id="chat_header"></h4>
                        </div>
                        <div class="card-body chat-content">

                        </div>

                        <div class="card-footer chat-form">
                            <form id="chat-form">
                                @csrf
                                <input type="text" class="form-control fp_send_message" placeholder="Pick a receiver"
                                       name="message">
                                <input type="hidden" name="receiver_id" id="receiver_id">
                                <button type="submit" class="btn btn-primary btn_submit">
                                    <i class="far fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            const userId = "{{ auth()->user()->id }}";
            let avatar = "";


            function scrollToBottom() {
                let chatContent = $('.chat-content');
                chatContent.scrollTop(chatContent.prop("scrollHeight"));
            }

            function toggleMessageInput(enabled) {
                $('.fp_send_message').prop('disabled', !enabled);
                $('.fp_send_message').prop('placeholder', enabled ? 'Write a message' : 'Pick a receiver');
                $('.btn_submit').prop('disabled', !enabled);
            }

            toggleMessageInput(false);

            $('.fp_chat_user').on('click', function () {
                toggleMessageInput(true);

                const senderId = $(this).data('user');
                const senderName = $(this).data('name');
                let clickedElemnt = $(this);

                $('#receiver_id').val(senderId);
                $('#mychatbox').attr('data-inbox', senderId);

                $.ajax({
                    method: 'GET',
                    url: '{{ route("admin.chat.get-conversation", ":senderId") }}'.replace(":senderId", senderId),
                    beforeSend: function () {
                        $('.chat-content').empty();
                        $('#chat_header').text("Chat with " + senderName);
                    },
                    success: function (response) {
                        console.log(response);
                        $('.chat-content').empty();
                        response.forEach(function (message) {
                            avatar = "{{ asset(':avatar') }}".replace(':avatar', message.sender.avatar);
                            let html = `
                            <div class="chat-item ${message.sender_id == userId ? "chat-right" : "chat-left"}">
                                <img style="width:50px;height:50px;object-fit:cover;" src="${avatar}">
                                <div class="chat-details">
                                    <div class="chat-text">${message.message}</div>
                                </div>
                            </div>
                        `;
                            $('.chat-content').append(html);
                        });

                        clickedElemnt.find(".got_new_message").html("")
                        scrollToBottom();
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching messages:", error);
                    }
                });
            });

            $('#chat-form').on('submit', function (e) {
                e.preventDefault();

                const formData = $(this).serialize();
                const message = $('.fp_send_message').val();

                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.chat.send-message') }}",
                    data: formData,
                    beforeSend: function () {
                        console.log('before:', avatar);
                        let html = `
                        <div class="chat-item chat-right">
                            <img style="width:50px;height:50px;object-fit:cover;" src="${avatar}">
                            <div class="chat-details">
                                <div class="chat-text">${message}</div>
                                <div class="chat-time">sending...</div>
                            </div>
                        </div>
                    `;
                        $('.chat-content').append(html);
                        $('.fp_send_message').val("");
                        scrollToBottom();

                        // remove beep notification
                        $(".fp_chat_user").each(function () {
                            let senderId = $(this).data('user');
                            if ($('#mychatbox').attr('data-inbox') == senderId) {
                                $(this).find(".got_new_message").html("");
                            }
                        })
                    },
                    success: function (response) {
                        console.log(response);

                    },
                    error: function (xhr, status, error) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            toastr.error(value);
                        });
                    }
                });
            });
        });
    </script>

@endpush

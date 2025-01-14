function scrollToBootom() {
    let chatContent = $('.chat-content');
    chatContent.scrollTop(chatContent.prop("scrollHeight"));
}


window.Echo.private("chat." + loggedInUserId).listen(
    "ChatEvent",
    (e) => {
        console.log(e);
        $('.message-envelope').addClass('beep');

        if (e.sender_id == $('#mychatbox').attr('data-inbox')) {
            let html = `
        <div class="chat-item chat-left" style=""><img style="width:50px;height:50px;object-fit:cover;" src="${e.avatar}"><div class="chat-details"><div class="chat-text">${e.message}</div><div class="chat-time">sending...</div></div></div>
        `
            $('.chat-content').append(html);
            scrollToBootom();
        }

        // show message notification
        $(".fp_chat_user").each(function(){
            let senderId = $(this).data('user');

            if(e.sender_id == senderId) {
                console.log(senderId);
                let html = `<i class="beep"></i>new message`;

                $(this).find(".got_new_message").html(html);
            }
        })
        console.log('hello')
    }
);


// var socket = io('http')


var chatBoxApp = $('.floating-chat');

chatBoxApp.click(openElement);

function openElement() {
    var messages = chatBoxApp.find('.messages');
    var textInput = chatBoxApp.find('.text-box');
    chatBoxApp.find('>i').hide();
    chatBoxApp.addClass('expand');
    chatBoxApp.find('.chat').addClass('enter');
    var strLength = textInput.val().length * 2;
    textInput.keydown(onMetaAndEnter).prop("disabled", false).focus();
    chatBoxApp.off('click', openElement);
    chatBoxApp.find('.header button').click(closeElement);
    chatBoxApp.find('#sendMessage').click(sendNewMessage);
    messages.scrollTop(messages.prop("scrollHeight"));
}

function closeElement() {
    chatBoxApp.find('.chat').removeClass('enter').hide();
    chatBoxApp.find('>i').show();
    chatBoxApp.removeClass('expand');
    chatBoxApp.find('.header button').off('click', closeElement);
    chatBoxApp.find('#sendMessage').off('click', sendNewMessage);
    chatBoxApp.find('.text-box').off('keydown', onMetaAndEnter).prop("disabled", true).blur();
    setTimeout(function () {
        chatBoxApp.find('.chat').removeClass('enter').show()
        chatBoxApp.click(openElement);
    }, 500);
}

function onMetaAndEnter(event) {
    if ((event.metaKey || event.ctrlKey) && event.keyCode == 13) {
        sendNewMessage();
    }
}

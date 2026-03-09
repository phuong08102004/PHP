const chatBtn = document.getElementById("chat-btn");
const chatBox = document.getElementById("chat-box");
const chatClose = document.getElementById("chat-close");
const chatBody = document.getElementById("chat-body");

if(chatBtn){
    chatBtn.onclick = () => chatBox.style.display = "flex";
}

if(chatClose){
    chatClose.onclick = () => chatBox.style.display = "none";
}

function sendMessage() {
    const input = document.getElementById("chat-input");
    const text = input.value.trim();
    if (!text) return;

    chatBody.innerHTML += `<div class="chat-msg user">${text}</div>`;
    input.value = "";
    chatBody.scrollTop = chatBody.scrollHeight;

    setTimeout(() => {
        chatBody.innerHTML += `
            <div class="chat-msg bot">
                Honey Bee đã nhận được tin nhắn 🍯<br>
                Chúng tôi sẽ phản hồi sớm!
            </div>`;
        chatBody.scrollTop = chatBody.scrollHeight;
    }, 800);
}

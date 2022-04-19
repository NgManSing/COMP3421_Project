const form = document.querySelector(".typing-area"),
	input_field = form.querySelector(".input-field"),
	sendButton = form.querySelector("button"),
	chatBox = document.querySelector(".chat-box");

input_field.focus();
input_field.onkeyup = () => {
	if (input_field.value != "") {
		sendButton.classList.add("active");
	} else {
		sendButton.classList.remove("active");
	}
};

chatBox.onmouseenter = () => {
	chatBox.classList.add("active");
};

chatBox.onmouseleave = () => {
	chatBox.classList.remove("active");
};

function scrollToBottom() {
	chatBox.scrollTop = chatBox.scrollHeight;
}

var last_responseText = "";
function showMsg() {
	const xhttp = new XMLHttpRequest();
	xhttp.onload = function() {
		if (this.responseText != last_responseText){
			last_responseText = this.responseText;
			document.getElementById("msg-box").innerHTML = this.responseText;
			document.getElementById("msg-box").scrollTo(0,document.body.scrollHeight);
		}
	}
	xhttp.open("GET", "./get_chat.php");
	xhttp.send();
}

//Auto userlist refresh
setInterval(showMsg, 500);

<?php
include ('fsession.php');
ini_set('memory_limit', '-1');

if(!isset($_SESSION['farmer_login_user'])){
    header("location: ../index.php");
    exit();
}

// FIX: Initialize variables early to prevent "Undefined Variable" warnings
$para1 = ''; 
$para2 = 'Farmer'; 
$user_check = $_SESSION['farmer_login_user'];

if (filter_var($user_check, FILTER_VALIDATE_EMAIL)) {
    $query4 = "SELECT * from farmerlogin where email='$user_check'";
} else {
    $query4 = "SELECT * from farmerlogin where phone_no='$user_check'";
}

$ses_sq4 = mysqli_query($conn, $query4);
if($ses_sq4 && $row4 = mysqli_fetch_assoc($ses_sq4)) {
    $para1 = $row4['farmer_id'];
    $para2 = $row4['farmer_name']; // Successfully fetched for the Namaste greeting
}
?>

<!DOCTYPE html>
<html>
<?php require ('fheader.php'); ?>
<style>
    body { background: linear-gradient(135deg, #11cdef 0%, #1171ef 100%); min-height: 100vh; }
    .chat-container { margin-top: -80px; }
    .chat-box { height: 60vh; overflow-y: auto; background: rgba(255, 255, 255, 0.95); border-radius: 15px; padding: 25px; box-shadow: inset 0 0 10px rgba(0,0,0,0.05); }
    .message { margin-bottom: 20px; padding: 12px 18px; border-radius: 20px; max-width: 80%; clear: both; font-size: 15px; line-height: 1.5; box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11); }
    .left-side { background: #ffffff; color: #32325d; float: left; border-bottom-left-radius: 2px; }
    .right-side { background: #2dce89; color: white; float: right; border-bottom-right-radius: 2px; }
    #userInput { border-radius: 30px; border: 2px solid #e9ecef; transition: 0.3s; }
    #userInput:focus { border-color: #2dce89; box-shadow: none; }
</style>

<body>
<?php include ('fnav.php'); ?>

<section class="section section-lg">
    <div class="container chat-container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-2xl border-0">
                    <div class="card-header bg-white d-flex align-items-center py-3">
                        <img src="../assets/img/chatgpt.svg" width="35" class="mr-3" alt="AI">
                        <h4 class="mb-0 text-primary font-weight-bold">SmartKrushi AI Assistant</h4>
                        <button class="btn btn-sm btn-outline-danger ml-auto" onclick="clearChat()">CLEAR CHAT</button>
                    </div>

                    <div class="card-body chat-box" id="chatbox">
                        <div class="message left-side">
                            Namaste, <b><?php echo htmlspecialchars($para2); ?></b>! How can I help you with your farm today?
                        </div>
                    </div>

                    <div class="card-footer bg-secondary">
                        <div class="input-group">
                            <input type="text" id="userInput" class="form-control" placeholder="Ask about crops, pests, or soil...">
                            <div class="input-group-append">
                                <button class="btn btn-success px-4" id="sendButton" type="button"><i class="fa fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require("footer.php");?>

<script>
const chatbox = $("#chatbox");
const userInput = $("#userInput");
const sendButton = $("#sendButton");
let messages = [];

function appendMessage(role, text) {
    const side = role === "user" ? 'right-side' : 'left-side';
    chatbox.append(`<div class="message ${side}">${text}</div>`);
    chatbox.animate({ scrollTop: chatbox[0].scrollHeight }, "slow");
}

sendButton.on("click", () => {
    const text = userInput.val().trim();
    if (!text) return;

    appendMessage("user", text);
    messages.push({ role: "user", content: text });
    
    userInput.val("");
    sendButton.prop("disabled", true);

   $.ajax({
    url: "fchat_handler.php",
    method: "POST",
    contentType: "application/json",
    dataType: "json",
    data: JSON.stringify({ messages: messages }),

    success: function(response){

        if(response.choices){

            let aiMsg = response.choices[0].message.content;

            appendMessage("assistant", aiMsg);

            messages.push({
                role:"assistant",
                content:aiMsg
            });

        }else{

            appendMessage("assistant","AI Error: "+response.error.message);

        }

    },

    error:function(){
        appendMessage("assistant","Server connection error.");
    },

    complete:function(){
        sendButton.prop("disabled",false);
    }
});
});

function clearChat() { chatbox.html(''); messages = []; }
userInput.on("keypress", (e) => { if(e.which == 13) sendButton.click(); });
</script>
</body>
</html>
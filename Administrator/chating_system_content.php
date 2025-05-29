<!-- Row start for chat system -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Chat with Users</h5>
                <!-- Dropdown to select user -->
                <div class="form-group">
                    <label for="userSelect">Select User:</label>
                    <select id="userSelect" class="form-control">
                        <option value="">-- Select User --</option>
                        <?php
                        // Fetch all users except admin
                        $sql = "SELECT id, username FROM users WHERE role_id = 2"; // Assuming role_id 3 is for admin
                        $user_result = $conn->query($sql);
                        while ($user = $user_result->fetch_assoc()) {
                            echo "<option value=\"" . htmlspecialchars($user['id']) . "\">" . htmlspecialchars($user['username']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- Chat history -->
                <div id="chatHistory" style="max-height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                    <!-- Chat messages will be loaded here via AJAX -->
                </div>
                <div class="form-group mt-2">
                    <label for="messageInput">Message:</label>
                    <textarea id="messageInput" class="form-control" rows="3" placeholder="Type your message here..."></textarea>
                </div>
                <button id="sendMessage" class="btn btn-primary mt-2">Send Message</button>
            </div>
        </div>
    </div>
</div>
<!-- Row end for chat system -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let selectedUserId = null;

    // Load chat history when a user is selected
    $('#userSelect').change(function() {
        selectedUserId = $(this).val();
        loadChatHistory(selectedUserId);
    });

    // Function to load chat history
    function loadChatHistory(userId) {
        $.ajax({
            url: 'Controller/load_chat.php', // Create this PHP file
            method: 'POST',
            data: { user_id: userId },
            success: function(response) {
                $('#chatHistory').html(response);
                $('#chatHistory').scrollTop($('#chatHistory')[0].scrollHeight); // Auto-scroll to the bottom
            }
        });
    }

    // Send message
    $('#sendMessage').click(function() {
        const message = $('#messageInput').val();
        if (selectedUserId && message) {
            $.ajax({
                url: 'Controller/send_message.php', // Create this PHP file
                method: 'POST',
                data: {
                    receiver_id: selectedUserId,
                    message: message
                },
                success: function(response) {
                    $('#messageInput').val(''); // Clear the input field
                    loadChatHistory(selectedUserId); // Reload chat history
                }
            });
        } else {
            alert("Please select a user and enter a message.");
        }
    });
});
</script>

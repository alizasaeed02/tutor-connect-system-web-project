<!-- Row start for chat system -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Chat with Instructors</h5>
                <!-- Dropdown to select instructor -->
                <div class="form-group">
                    <label for="instructorSelect">Select Instructor:</label>
                    <select id="instructorSelect" class="form-control">
                        <option value="">-- Select Instructor --</option>
                        <?php
                        while ($instructor = $user_result->fetch_assoc()) {
                            echo "<option value=\"" . htmlspecialchars($instructor['id']) . "\">" . htmlspecialchars($instructor['username']) . "</option>";
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
    let selectedInstructorId = null;

    // Load chat history when an instructor is selected
    $('#instructorSelect').change(function() {
        selectedInstructorId = $(this).val();
        loadChatHistory(selectedInstructorId);
    });

    // Function to load chat history
    function loadChatHistory(instructorId) {
        $.ajax({
            url: 'Controller/load_chat_student.php', // Create this PHP file
            method: 'POST',
            data: { instructor_id: instructorId },
            success: function(response) {
                $('#chatHistory').html(response);
                $('#chatHistory').scrollTop($('#chatHistory')[0].scrollHeight); // Auto-scroll to the bottom
            }
        });
    }

    // Send message
    $('#sendMessage').click(function() {
        const message = $('#messageInput').val();
        if (selectedInstructorId && message) {
            $.ajax({
                url: 'Controller/send_message_student.php', // Create this PHP file
                method: 'POST',
                data: {
                    receiver_id: selectedInstructorId,
                    message: message
                },
                success: function(response) {
                    $('#messageInput').val(''); // Clear the input field
                    loadChatHistory(selectedInstructorId); // Reload chat history
                }
            });
        } else {
            alert("Please select an instructor and enter a message.");
        }
    });
});
</script>

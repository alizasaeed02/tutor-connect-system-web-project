<!-- Search Form -->
<div class="container mt-5">
    <div class="row mb-4" id="stickySearch">
        <div class="col-md-12">
            <div class="input-group">
                <label for="searchInput" class="input-group-text bg-primary text-white">Search</label>
                <input type="text" id="searchInput" class="form-control" placeholder="Type Tutor Name or Course Title" onkeyup="filterCourses()" aria-label="Search">
                <button class="btn btn-primary" type="button" onclick="filterCourses()">Search</button>
            </div>
        </div>
    </div>


    <!-- Course Cards -->
    <div class="row" id="courseCardsContainer">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-xxl-4 col-lg-4 col-md-6 mb-4 course-card" data-tutor="<?php echo htmlspecialchars($row['tutor_name']); ?>" data-course="<?php echo htmlspecialchars($row['course_name']); ?>">
                    <div class="card">
                        <img src="../assets/uploads/<?php echo htmlspecialchars($row['tutor_image']); ?>" width="150" height="400" class="card-img-top" alt="Tutor Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['course_name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                            <h6 class="card-price">$<?php echo htmlspecialchars($row['price']); ?></h6>
                            <p class="card-text"><small class="text-muted">Tutor: <?php echo htmlspecialchars($row['tutor_name']); ?></small></p>
                            <p class="card-text"><small class="text-muted">Section: <?php echo htmlspecialchars($row['section_name']); ?></small></p> <!-- Display section name -->
                            
                            <!-- Play Demo Video Button -->
                            <?php if (!empty($row['video_path'])): ?>
                                <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#demoVideoModal" 
                                    onclick="playDemoVideo('<?php echo $row['video_path']; ?>')">
                                    Play Demo Video
                                </button>
                            <?php else: ?>
                                <p><em>No demo video available.</em></p>
                            <?php endif; ?>
                             
                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#paymentModal" 
                                data-course-id="<?php echo htmlspecialchars($row['course_id']); ?>" 
                                data-course-price="<?php echo htmlspecialchars($row['price']); ?>">
                                Register Now
                            </button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <p>No courses found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="Controller/register_course.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="courseId" name="course_id">
                    <div class="mb-3">
                        <label for="coursePrice" class="form-label">Course Price</label>
                        <input type="text" class="form-control" id="coursePrice" name="course_price" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="transactionNo" class="form-label">Transaction Number</label>
                        <input type="text" class="form-control" id="transactionNo" name="transaction_no" required>
                    </div>
                    <div class="mb-3">
                        <label for="receiptFile" class="form-label">Upload Receipt</label>
                        <input type="file" class="form-control" id="receiptFile" name="receipt_file" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Demo Video Modal -->
<div class="modal fade" id="demoVideoModal" tabindex="-1" aria-labelledby="demoVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoVideoModalLabel">Demo Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <video id="demoVideoPlayer" controls style="width: 100%;">
                    <source id="demoVideoSource" src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to play the demo video when the button is clicked
    function playDemoVideo(videoPath) {
        const videoPlayer = document.getElementById('demoVideoPlayer');
        const videoSource = document.getElementById('demoVideoSource');
        
        // Set the video source and reload the player
        videoSource.src = '../uploads/courses/' + videoPath;
        videoPlayer.load(); // Reload the video player with the new source
    }

    // Ensure the document is fully loaded before running other event listeners
    document.addEventListener('DOMContentLoaded', (event) => {
        var paymentModal = document.getElementById('paymentModal');
        paymentModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget;
            // Extract info from data-* attributes
            var courseId = button.getAttribute('data-course-id');
            var coursePrice = button.getAttribute('data-course-price');
            // Update the modal's hidden input with the course ID
            var modalBodyIdInput = paymentModal.querySelector('.modal-body input#courseId');
            var modalBodyPriceInput = paymentModal.querySelector('.modal-body input#coursePrice');
            modalBodyIdInput.value = courseId;
            modalBodyPriceInput.value = coursePrice;
        });

        // Stop the video when the modal is closed
        document.getElementById('demoVideoModal').addEventListener('hidden.bs.modal', function () {
            const videoPlayer = document.getElementById('demoVideoPlayer');
            videoPlayer.pause(); // Pause the video
            videoPlayer.currentTime = 0; // Reset the video to the start
        });
    });

    // Function to filter courses based on search input
    function filterCourses() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const courseCards = document.querySelectorAll('.course-card');

        courseCards.forEach(card => {
            const tutorName = card.getAttribute('data-tutor').toLowerCase();
            const courseTitle = card.getAttribute('data-course').toLowerCase();

            if (tutorName.includes(searchInput) || courseTitle.includes(searchInput)) {
                card.style.display = ''; // Show the card
            } else {
                card.style.display = 'none'; // Hide the card
            }
        });
    }

</script>

<style>
    /* Custom styles for the sticky search input */
    #stickySearch {
        position: sticky;
        top: 20px; /* Adjust the top offset */
        z-index: 1000; /* Ensure it is above other content */
        background-color: white; /* Background color to make it stand out */
        padding: 15px; /* Add some padding */
        border-radius: 0.5rem; /* Round corners */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add a slight shadow */
    }

    /* Keep previous styles for input and button */
    .input-group {
        border-radius: 0.5rem;
        overflow: hidden; /* To make sure the border radius is respected */
        transition: all 0.3s ease; /* Transition for the whole group */
    }

    .input-group-text {
        background-color: #007bff; /* Bootstrap primary color */
        color: white; /* Text color */
        transition: background-color 0.3s ease; /* Transition for background color */
    }

    .input-group-text:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }

    .form-control {
        border: 2px solid #007bff; /* Matching border color */
        transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Transition for border and shadow */
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Add shadow on focus */
        border-color: #0056b3; /* Darker border color on focus */
        outline: none; /* Remove default outline */
    }

    .btn-primary {
        border-radius: 0; /* Make the button edges square to fit in the group */
        transition: transform 0.3s ease; /* Button transform effect */
    }

    .btn-primary:hover {
        transform: scale(1.05); /* Scale up on hover */
    }
</style>

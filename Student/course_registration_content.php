<!-- Row start -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-hover m-0">
                        <thead>
                            <tr>
                                <th scope="col">Course Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Video</th> <!-- New column for video -->
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                                        <td><?php echo htmlspecialchars($row['payment_status']); ?></td>
                                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                        <td>
                                            <?php if (!empty($row['video_path'])): ?>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#playVideoModal" 
                                                    onclick="playVideo('<?php echo $row['video_path']; ?>')">
                                                    Play Video
                                                </button>
                                            <?php else: ?>
                                                No Video
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCourseRegistrationModal" onclick="setDeleteModalData(<?php echo $row['id']; ?>)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="6">No Course Registration found.</td> <!-- Updated colspan -->
                                </tr>
                            <?php
                            }
                            $stmt->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->

<!-- Play Video Modal -->
<div class="modal fade" id="playVideoModal" tabindex="-1" aria-labelledby="playVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="playVideoModalLabel">Play Course Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <video id="courseVideoPlayer" controls style="width: 100%;">
                    <source id="videoSource" src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>

<!-- Delete Course Registration Modal -->
<div class="modal fade" id="deleteCourseRegistrationModal" tabindex="-1" aria-labelledby="deleteCourseRegistrationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCourseRegistrationModalLabel">Delete Course Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Course Registration?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteCourseRegistrationForm" action="Controller/delete_course_registration.php" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" id="deleteCourseRegistrationId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function setDeleteModalData(id) {
        document.getElementById('deleteCourseRegistrationId').value = id;
    }

    function playVideo(videoPath) {
        const videoPlayer = document.getElementById('courseVideoPlayer');
        const videoSource = document.getElementById('videoSource');
        
        // Set the video source and reload the player
        videoSource.src = '../uploads/courses/' + videoPath;
        videoPlayer.load(); // Reload the video player with the new source
    }

    // Stop the video when the modal is closed
    document.getElementById('playVideoModal').addEventListener('hidden.bs.modal', function () {
        const videoPlayer = document.getElementById('courseVideoPlayer');
        videoPlayer.pause(); // Pause the video
        videoPlayer.currentTime = 0; // Reset the video to the start
    });
</script>

<?php
$conn->close();
?>

<!-- Row start -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <!-- Display success or error messages -->
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert <?php echo $_SESSION['message_class']; ?>">
                        <?php echo $_SESSION['message']; unset($_SESSION['message'], $_SESSION['message_class']); ?>
                    </div>
                <?php endif; ?>

                <!-- Create Course Button -->
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createCourseModal">Create Course</button>
                
                <!-- Courses Table -->
                <div class="table-responsive">
                    <table class="table align-middle table-hover m-0">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Price</th>
                                <th scope="col">Section</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Video</th> <!-- New column for the play button -->
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                                        <td><?php echo htmlspecialchars($row['section_name'] ? $row['section_name'] : 'No Section'); ?></td>
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
                                            <!-- Edit Button -->
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editCourseModal" 
                                                onclick="setEditModalData(<?php echo htmlspecialchars(json_encode([
                                                    'id' => $row['id'],
                                                    'name' => $row['name'],
                                                    'description' => $row['description'],
                                                    'price' => $row['price'],
                                                    'section_id' => $row['section_id']
                                                ])); ?>)">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCourseModal" onclick="setDeleteModalData(<?php echo $row['id']; ?>)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">No courses found.</td> <!-- Updated colspan -->
                                </tr>
                            <?php endif; ?>
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


<!-- Create Course Modal -->
<div class="modal fade" id="createCourseModal" tabindex="-1" aria-labelledby="createCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCourseModalLabel">Create Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createCourseForm" action="Controller/create_course.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create">
                    <div class="mb-3">
                        <label for="createName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="createName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="createDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="createDescription" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="createPrice" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="createPrice" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="createSection" class="form-label">Section</label>
                        <select class="form-select" id="createSection" name="section_id">
                            <option value="">Select Section</option>
                            <?php while ($section = $sections_result->fetch_assoc()) { ?>
                                <option value="<?php echo $section['id']; ?>"><?php echo htmlspecialchars($section['name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="courseVideo" class="form-label">Upload Video</label>
                        <input type="file" class="form-control" id="courseVideo" name="course_video" accept="video/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Course</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Course Modal -->
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCourseForm" action="Controller/edit_course.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="editCourseId">
                    
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="editPrice" name="price" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editSection" class="form-label">Section</label>
                        <select class="form-select" id="editSection" name="section_id">
                            <option value="">Select Section</option>
                            <?php 
                            $sections_result = $conn->query($sections_sql); // Re-run the query for the section options
                            while ($section = $sections_result->fetch_assoc()) { ?>
                                <option value="<?php echo $section['id']; ?>"><?php echo htmlspecialchars($section['name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editVideo" class="form-label">Upload New Video (optional)</label>
                        <input type="file" class="form-control" id="editVideo" name="course_video" accept="video/*">
                    </div>

                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Course Modal -->
<div class="modal fade" id="deleteCourseModal" tabindex="-1" aria-labelledby="deleteCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCourseModalLabel">Delete Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this course?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteCourseForm" action="Controller/delete_course.php" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" id="deleteCourseId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to play the video when Play button is clicked
    function playVideo(videoPath) {
        const videoPlayer = document.getElementById('courseVideoPlayer');
        const videoSource = document.getElementById('videoSource');
        
        // Set the video source and reload the player
        videoSource.src = '../uploads/courses/' + videoPath;
        videoPlayer.load(); // Reload the video player with the new source
    }

    // Function to stop the video when the modal is closed
    document.getElementById('playVideoModal').addEventListener('hidden.bs.modal', function () {
        const videoPlayer = document.getElementById('courseVideoPlayer');
        videoPlayer.pause(); // Pause the video
        videoPlayer.currentTime = 0; // Reset the video to the start
    });

    function setEditModalData(course) {
        document.getElementById('editCourseId').value = course.id;
        document.getElementById('editName').value = course.name;
        document.getElementById('editDescription').value = course.description;
        document.getElementById('editPrice').value = course.price;

        // Set the section dropdown
        const sectionSelect = document.getElementById('editSection');
        
        // Reset the section dropdown before setting it
        sectionSelect.value = ""; 
        
        if (course.section_id) {
            sectionSelect.value = course.section_id; // Set the current section for the course
        }
    }

    function setDeleteModalData(id) {
        document.getElementById('deleteCourseId').value = id;
    }

</script>

<?php
$conn->close();
?>

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
                                <th scope="col">Course Description</th>
                                <th scope="col">Material Title</th>
                                <th scope="col">Content</th>
                                <th scope="col">Download</th>
                                <th scope="col">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $file_path = '../assets/uploads/' . $row['file_path'];
                                    $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
                            ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['course_description']); ?></td>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['content']); ?></td>
                                        <td>
                                            <?php if ($row['file_path'] && file_exists($file_path)) { ?>
                                                <?php if (in_array($file_extension, ['mp4', 'avi', 'mov', 'wmv'])) { ?>
                                                    <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#videoModal" data-video="<?php echo htmlspecialchars($file_path); ?>">
                                                        Play Video
                                                    </button>
                                                <?php } else { ?>
                                                    <a href="<?php echo htmlspecialchars($file_path); ?>" class="btn btn-sm btn-secondary" download>
                                                        Download
                                                    </a>
                                                <?php } ?>
                                            <?php } else { echo 'File not available'; } ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="3">No Course Registration found.</td>
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

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Play Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <video id="videoPlayer" width="100%" height="600px" controls autoplay>
                    <source id="videoSource" src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoModal = document.getElementById('videoModal');
    videoModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const videoPath = button.getAttribute('data-video');
        const videoSource = document.getElementById('videoSource');
        videoSource.src = videoPath;
        const videoPlayer = document.getElementById('videoPlayer');
        videoPlayer.load();
    });

    videoModal.addEventListener('hide.bs.modal', function() {
        const videoPlayer = document.getElementById('videoPlayer');
        videoPlayer.pause();
    });
});
</script>

<?php
$conn->close();
?>

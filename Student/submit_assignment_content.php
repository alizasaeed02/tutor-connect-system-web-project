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
                                <th scope="col">Material Type</th>
                                <th scope="col">Content</th>
                                <th scope="col">Download</th>
                                <th scope="col">From Date</th>
                                <th scope="col">To Date</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Submit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $file_path = '../assets/uploads/' . $row['file_path'];
                                    $deadline_materials_id = htmlspecialchars($row['deadline_materials_id']); // Assuming 'deadline_materials_id' is the primary key of the deadline_materials table
                            ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['course_description']); ?></td>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                                        <td><?php echo htmlspecialchars($row['content']); ?></td>
                                        <td>
                                            <?php if ($row['file_path'] && file_exists($file_path)) { ?>
                                                <a href="<?php echo htmlspecialchars($file_path); ?>" class="btn btn-sm btn-secondary" download>
                                                    Download
                                                </a>
                                            <?php } else {
                                                echo 'File not available';
                                            } ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['from_date']); ?></td>
                                        <td><?php echo htmlspecialchars($row['to_date']); ?></td>
                                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                        <td>
                                            <?php if (new DateTime() <= new DateTime($row['to_date'])) { ?>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#submitAssignmentModal" data-id="<?php echo $deadline_materials_id; ?>">
                                                    Assignment
                                                </button>
                                            <?php } else {
                                                echo 'Submission closed';
                                            } ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="10">No Course Registration found.</td>
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

<?php
$conn->close();
?>

<!-- Assignment Submission Modal -->
<div class="modal fade" id="submitAssignmentModal" tabindex="-1" aria-labelledby="submitAssignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="assignmentForm" method="POST" action="Controller/submit_assignment_action.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="submitAssignmentModalLabel">Submit Assignment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="assignmentFile" class="form-label">Upload Assignment</label>
                        <input type="file" class="form-control" id="assignmentFile" name="assignmentFile" required>
                    </div>
                    <input type="hidden" name="deadline_material_id" id="deadlineMaterialId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var submitAssignmentModal = document.getElementById('submitAssignmentModal');
    submitAssignmentModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var deadlineMaterialsId = button.getAttribute('data-id');
        var modalBodyInput = submitAssignmentModal.querySelector('#deadlineMaterialId');
        modalBodyInput.value = deadlineMaterialsId;
    });
</script>
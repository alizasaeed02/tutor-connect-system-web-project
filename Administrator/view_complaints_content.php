<!-- Row start for displaying complaints -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <h5>All Complaints</h5>
                <div class="table-responsive">
                    <table class="table align-middle table-hover m-0">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Student</th>
                                <th scope="col">Complaint</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>
                                <th scope="col">Response</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                $counter = 1;
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><?php echo $counter++; ?></td>
                                        <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['complaint_text']); ?></td>
                                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                        <td><?php echo htmlspecialchars($row['admin_response']); ?></td>
                                        <td>
                                            <?php if ($row['status'] === 'pending') { // Check if status is pending ?>
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#responseModal" 
                                                    data-complaint-id="<?php echo $row['id']; ?>"
                                                    data-complaint-text="<?php echo htmlspecialchars($row['complaint_text']); ?>"
                                                    data-student-name="<?php echo htmlspecialchars($row['student_name']); ?>">
                                                    Respond
                                                </button>
                                            <?php } else { ?>
                                                <span class="text-muted">No action needed</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="7">No complaints found.</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row end for displaying complaints -->

<!-- Modal for Response -->
<div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="responseModalLabel">Respond to Complaint</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Student:</strong> <span id="modalStudentName"></span></p>
                <p><strong>Complaint:</strong> <span id="modalComplaintText"></span></p>
                <form method="POST" action="Controller/process_response.php" id="responseForm">
                    <input type="hidden" name="complaint_id" id="complaintId">
                    <div class="form-group">
                        <label for="adminResponse">Response:</label>
                        <textarea id="adminResponse" name="admin_response" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Response</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const responseModal = document.getElementById('responseModal');
    responseModal.addEventListener('show.bs.modal', (event) => {
        // Get data attributes from the button that triggered the modal
        const button = event.relatedTarget; // Button that triggered the modal
        const complaintId = button.getAttribute('data-complaint-id');
        const complaintText = button.getAttribute('data-complaint-text');
        const studentName = button.getAttribute('data-student-name');

        // Update the modal's content.
        document.getElementById('modalStudentName').textContent = studentName;
        document.getElementById('modalComplaintText').textContent = complaintText;
        document.getElementById('complaintId').value = complaintId; // Set the complaint ID in the hidden input
    });
</script>

<?php
$stmt->close();
$conn->close();
?>

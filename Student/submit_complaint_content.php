<!-- Row start for complaint form -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Submit a Complaint</h5>
                <form method="POST" action="Controller/process_complaint.php">
                    <div class="form-group">
                        <label for="complaintText">Complaint:</label>
                        <textarea id="complaintText" name="complaint_text" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Complaint</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Row end for complaint form -->

<!-- Row start for displaying complaints -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Your Complaints</h5>
                <div class="table-responsive">
                    <table class="table align-middle table-hover m-0">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Complaint</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>
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
                                        <td><?php echo htmlspecialchars($row['complaint_text']); ?></td>
                                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="4">No complaints found.</td>
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

<?php
$stmt->close();
$conn->close();
?>
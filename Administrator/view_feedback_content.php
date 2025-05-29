<!-- Row start for displaying feedback -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-hover m-0">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Course</th>
                                <th scope="col">Student</th>
                                <th scope="col">Rating</th>
                                <th scope="col">Comments</th>
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
                                        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                        <td>
                                            <?php
                                            // Display stars based on the rating
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $row['rating']) {
                                                    echo '<span class="fa fa-star" style="color: gold;"></span>'; // Filled star
                                                } else {
                                                    echo '<span class="fa fa-star" style="color: lightgray;"></span>'; // Empty star
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['comments']); ?></td>
                                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="6">No feedback found.</td>
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
<!-- Row end for displaying feedback -->

<?php
$stmt->close();
$conn->close();
?>

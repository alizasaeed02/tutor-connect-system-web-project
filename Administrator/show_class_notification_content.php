<!-- Row start -->
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
                                <th scope="col">Title</th>
                                <th scope="col">Content</th>
                                <th scope="col">Date</th>
                                <th scope="col">To Time</th>
                                <th scope="col">From Time</th>
                                <th scope="col">Action</th> <!-- Mark as Read button -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                $counter = 1;
                                while ($row = $result->fetch_assoc()) {
                                    // Compare the class_date with the current date
                                    $currentDate = date('Y-m-d');
                                    $rowClass = ($row['class_date'] < $currentDate) ? 'background-color: orangered;' : 'background-color: greenyellow;';
                            ?>
                                    <tr>
                                        <td><?php echo $counter++; ?></td> <!-- Incrementing counter for S.No -->
                                        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['content']); ?></td>
                                        <td style="white-space: nowrap; <?php echo $rowClass; ?>"><?php echo htmlspecialchars($row['class_date']); ?></td>
                                        <td><?php echo htmlspecialchars($row['from_time']); $currentDate ?></td>
                                        <td><?php echo htmlspecialchars($row['to_time']); ?></td>
                                        <td>
                                            <?php if ($row['is_read'] == 0) { ?>
                                                <form method="POST" action="Controller/mark_as_read.php" style="display:inline;">
                                                    <input type="hidden" name="notification_id" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" class="btn btn-primary btn-sm">Mark as Read</button>
                                                </form>
                                            <?php } else { ?>
                                                <span class="badge bg-success">Read</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7">No Class Notifications found.</td>
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

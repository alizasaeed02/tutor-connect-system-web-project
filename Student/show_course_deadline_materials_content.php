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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $file_path = '../assets/uploads/' . $row['file_path'];
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
                                        <?php } else { echo 'File not available'; } ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['from_date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['to_date']); ?></td>
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

<?php
$conn->close();
?>

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
                                <th scope="col">Tutor</th>
                                <th scope="col">Title</th>
                                <th scope="col">Content</th>
                                <th scope="col">Date</th>
                                <th scope="col">From Time</th>
                                <th scope="col">To Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['tutor_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['content']); ?></td>
                                        <td><?php echo htmlspecialchars($row['meeting_date']); ?></td>
                                        <td><?php echo htmlspecialchars($row['from_time']); ?></td>
                                        <td><?php echo htmlspecialchars($row['to_time']); ?></td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7">No Meeting Notifications found.</td>
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
<!-- Row end -->

<!-- Row start -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createMeetingNotificationModal">Create Meeting Notification</button>
                <div class="table-responsive">
                    <table class="table align-middle table-hover m-0">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Title</th>
                                <th scope="col">Content</th>
                                <th scope="col">Date</th>
                                <th scope="col">To Time</th>
                                <th scope="col">From Time</th>
                                <!-- <th scope="col">Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['content']); ?></td>
                                        <td><?php echo htmlspecialchars($row['meeting_date']); ?></td>
                                        <td><?php echo htmlspecialchars($row['from_time']); ?></td>
                                        <td><?php echo htmlspecialchars($row['to_time']); ?></td>
                                        <!-- <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editMeetingNotificationModal" onclick="setEditModalData(<?php echo htmlspecialchars(json_encode($row)); ?>)"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteMeetingNotificationModal" onclick="setDeleteModalData(<?php echo $row['id']; ?>)"><i class="bi bi-trash"></i></button>
                                        </td> -->
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

<!-- Create Meeting Notification Modal -->
<div class="modal fade" id="createMeetingNotificationModal" tabindex="-1" aria-labelledby="createMeetingNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createMeetingNotificationModalLabel">Create Meeting Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createMeetingNotificationForm" action="Controller/create_meeting_notification.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create">
                    <div class="mb-3">
                        <label for="createTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="createTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="createContent" class="form-label">Content</label>
                        <textarea class="form-control" id="createContent" name="content"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="createMeetingDate" class="form-label">Meeting Date</label>
                        <input type="date" class="form-control" id="createMeetingDate" name="meeting_date">
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="createFromTime" class="form-label">From Time</label>
                            <input type="time" class="form-control" id="createFromTime" name="from_time">
                        </div>
                        <div class="col-6">
                            <label for="createToTime" class="form-label">To Time</label>
                            <input type="time" class="form-control" id="createToTime" name="to_time">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Meeting</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Meeting Notification Modal -->
<!-- This modal will be similar to your "Edit Class Notification Modal" -->

<script>
    function setEditModalData(meeting_notification) {
        document.getElementById('editMeetingNotificationId').value = meeting_notification.id;
        document.getElementById('editParentId').value = meeting_notification.parent_id;
        document.getElementById('editTitle').value = meeting_notification.title;
        document.getElementById('editContent').value = meeting_notification.content;
        document.getElementById('editMeetingDate').value = meeting_notification.meeting_date;
        document.getElementById('editFromTime').value = meeting_notification.from_time;
        document.getElementById('editToTime').value = meeting_notification.to_time;
    }

    function setDeleteModalData(id) {
        document.getElementById('deleteMeetingNotificationId').value = id;
    }
</script>

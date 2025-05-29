<!-- Row start -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createClassNotificationModal">Create Class Notification</button>
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
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['content']); ?></td>
                                        <td style="text-wrap: nowrap;"><?php echo htmlspecialchars($row['class_date']); ?></td>
                                        <td><?php echo htmlspecialchars($row['from_time']); ?></td>
                                        <td><?php echo htmlspecialchars($row['to_time']); ?></td>
                                        <td style="text-wrap: nowrap;">
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editClassNotificationModal" onclick="setEditModalData(<?php echo htmlspecialchars(json_encode($row)); ?>)"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteClassNotificationModal" onclick="setDeleteModalData(<?php echo $row['id']; ?>)"><i class="bi bi-trash"></i></button>
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

<!-- Create Class Notification Modal -->
<div class="modal fade" id="createClassNotificationModal" tabindex="-1" aria-labelledby="createClassNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createClassNotificationModalLabel">Create Class Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createClassNotificationForm" action="Controller/create_class_notification.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create">
                    <div class="mb-3">
                        <label for="createCourseId" class="form-label">Course</label>
                        <select class="form-control" id="createCourseId" name="course_id" required>
                            <?php
                            $user_id = $_SESSION['user_id'];
                            // SQL query to get courses assigned to the instructor
                            $course_sql = "SELECT c.id, c.name
                                           FROM course_instructor_assigned cia
                                           JOIN courses c ON cia.course_id = c.id
                                           WHERE cia.instructor_id = ?";

                            $stmt = $conn->prepare($course_sql);
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $course_result = $stmt->get_result();
                            while ($course = $course_result->fetch_assoc()) {
                                echo "<option value=\"" . htmlspecialchars($course['id']) . "\">" . htmlspecialchars($course['name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="createTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="createTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="createContent" class="form-label">Content</label>
                        <textarea class="form-control" id="createContent" name="content"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="createClassDate" class="form-label">Class Date</label>
                        <input type="date" class="form-control" id="createClassDate" name="class_date">
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
                    
                    <button type="submit" class="btn btn-primary">Class Notification</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit ClassNotification Modal -->
<div class="modal fade" id="editClassNotificationModal" tabindex="-1" aria-labelledby="editClassNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editClassNotificationModalLabel">Edit Class Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editClassNotificationForm" action="Controller/edit_class_notification.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="editClassNotificationId">
                    <input type="hidden" name="existing_file_path" id="editExistingFilePath">
                    <div class="mb-3">
                        <label for="editCourseId" class="form-label">Course</label>
                        <select class="form-control" id="editCourseId" name="course_id" required>
                            <?php
                            $user_id = $_SESSION['user_id'];
                            // SQL query to get courses assigned to the instructor
                            $course_sql = "SELECT c.id, c.name
                                           FROM course_instructor_assigned cia
                                           JOIN courses c ON cia.course_id = c.id
                                           WHERE cia.instructor_id = ?";

                            $stmt = $conn->prepare($course_sql);
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $course_result = $stmt->get_result();
                            while ($course = $course_result->fetch_assoc()) {
                                $selected = $course['id'] == $class_notification['course_id'] ? 'selected' : '';
                                echo "<option value=\"" . htmlspecialchars($course['id']) . "\" $selected>" . htmlspecialchars($course['name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="editTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="editContent" class="form-label">Content</label>
                        <textarea class="form-control" id="editContent" name="content"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editClassDate" class="form-label">Class Date</label>
                        <input type="date" class="form-control" id="editClassDate" name="class_date">
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="editFromTime" class="form-label">From Time</label>
                            <input type="time" class="form-control" id="editFromTime" name="from_time">
                        </div>
                        <div class="col-6">
                            <label for="editToTime" class="form-label">To Time</label>
                            <input type="time" class="form-control" id="editToTime" name="to_time">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete ClassNotification Modal -->
<div class="modal fade" id="deleteClassNotificationModal" tabindex="-1" aria-labelledby="deleteClassNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteClassNotificationModalLabel">Delete Class Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this class notification?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteClassNotificationForm" action="Controller/delete_class_notification.php" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" id="deleteClassNotificationId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function setEditModalData(class_notification) {
        document.getElementById('editClassNotificationId').value = class_notification.id;
        document.getElementById('editCourseId').value = class_notification.course_id;
        document.getElementById('editTitle').value = class_notification.title;
        document.getElementById('editContent').value = class_notification.content;
        document.getElementById('editClassDate').value = class_notification.class_date;
        document.getElementById('editFromTime').value = class_notification.from_time;
        document.getElementById('editToTime').value = class_notification.to_time;
        // You may need to handle file input differently
    }

    function setDeleteModalData(id) {
        document.getElementById('deleteClassNotificationId').value = id;
    }
</script>

<?php
$conn->close();
?>
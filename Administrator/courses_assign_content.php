<!-- Row start -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createAssignmentModal">Assign Instructor</button>
                <div class="table-responsive">
                    <table class="table align-middle table-hover m-0">
                        <thead>
                            <tr>
                                <th scope="col">Tutor</th>
                                <th scope="col">Instructor</th>
                                <th scope="col">Assigned At</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['instructor_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['assigned_at']); ?></td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editAssignmentModal" onclick="setEditModalData(<?php echo htmlspecialchars(json_encode($row)); ?>)"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAssignmentModal" onclick="setDeleteModalData(<?php echo $row['id']; ?>)"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4">No assignments found.</td>
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

<!-- Create Assignment Modal -->
<div class="modal fade" id="createAssignmentModal" tabindex="-1" aria-labelledby="createAssignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAssignmentModalLabel">Assign Instructor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createAssignmentForm" action="Controller/create_courses_assign.php" method="POST">
                    <input type="hidden" name="action" value="create">
                    <div class="mb-3">
                        <label for="createCourseId" class="form-label">Course</label>
                        <select class="form-control" id="createCourseId" name="course_id" required>
                            <?php
                            // Fetch courses for the select options
                            $course_sql = "SELECT id, name FROM courses";
                            $course_result = $conn->query($course_sql);
                            while ($course = $course_result->fetch_assoc()) {
                                echo "<option value=\"" . htmlspecialchars($course['id']) . "\">" . htmlspecialchars($course['name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="createInstructorId" class="form-label">Instructor</label>
                        <select class="form-control" id="createInstructorId" name="instructor_id" required>
                            <?php
                            // Fetch instructors for the select options
                            $instructor_sql = "SELECT id, username FROM users WHERE role_id = 2"; // role_id 2 for instructors
                            $instructor_result = $conn->query($instructor_sql);
                            while ($instructor = $instructor_result->fetch_assoc()) {
                                echo "<option value=\"" . htmlspecialchars($instructor['id']) . "\">" . htmlspecialchars($instructor['username']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Assign Instructor</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Assignment Modal -->
<div class="modal fade" id="editAssignmentModal" tabindex="-1" aria-labelledby="editAssignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAssignmentModalLabel">Edit Assignment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAssignmentForm" action="Controller/edit_courses_assign.php" method="POST">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="editAssignmentId">
                    <div class="mb-3">
                        <label for="editCourseId" class="form-label">Course</label>
                        <select class="form-control" id="editCourseId" name="course_id" required>
                            <?php
                            // Fetch courses for the select options
                            $course_sql = "SELECT id, name FROM courses";
                            $course_result = $conn->query($course_sql);
                            while ($course = $course_result->fetch_assoc()) {
                                echo "<option value=\"" . htmlspecialchars($course['id']) . "\">" . htmlspecialchars($course['name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editInstructorId" class="form-label">Instructor</label>
                        <select class="form-control" id="editInstructorId" name="instructor_id" required>
                            <?php
                            // Fetch instructors for the select options
                            $instructor_sql = "SELECT id, username FROM users WHERE role_id = 2"; // role_id 2 for instructors
                            $instructor_result = $conn->query($instructor_sql);
                            while ($instructor = $instructor_result->fetch_assoc()) {
                                echo "<option value=\"" . htmlspecialchars($instructor['id']) . "\">" . htmlspecialchars($instructor['username']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Assignment Modal -->
<div class="modal fade" id="deleteAssignmentModal" tabindex="-1" aria-labelledby="deleteAssignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAssignmentModalLabel">Delete Assignment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this assignment?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteAssignmentForm" action="Controller/delete_courses_assign.php" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" id="deleteAssignmentId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function setEditModalData(row) {
    document.getElementById('editAssignmentId').value = row.id;
    document.getElementById('editCourseId').value = row.course_id;
    document.getElementById('editInstructorId').value = row.instructor_id;
}

function setDeleteModalData(id) {
    document.getElementById('deleteAssignmentId').value = id;
}
</script>

<?php
$conn->close();
?>

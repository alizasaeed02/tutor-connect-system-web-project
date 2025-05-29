<!-- Row start -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createMaterialModal">Create Material</button>
                <div class="table-responsive">
                    <table class="table align-middle table-hover m-0">
                        <thead>
                            <tr>
                                <th scope="col">Course</th>
                                <th scope="col">Title</th>
                                <th scope="col">Content</th>
                                <th scope="col">File</th>
                                <th scope="col">Created At</th>
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
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['content']); ?></td>
                                        <td><?php echo htmlspecialchars($row['file_path']); ?></td>
                                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editMaterialModal" onclick="setEditModalData(<?php echo htmlspecialchars(json_encode($row)); ?>)"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteMaterialModal" onclick="setDeleteModalData(<?php echo $row['id']; ?>)"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="9">No materials found.</td>
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

<!-- Create Material Modal -->
<div class="modal fade" id="createMaterialModal" tabindex="-1" aria-labelledby="createMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createMaterialModalLabel">Create Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createMaterialForm" action="Controller/create_course_material.php" method="POST" enctype="multipart/form-data">
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
                        <label for="createFile" class="form-label">Upload File</label>
                        <input type="file" class="form-control" id="createFile" name="file">
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Material Modal -->
<div class="modal fade" id="editMaterialModal" tabindex="-1" aria-labelledby="editMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMaterialModalLabel">Edit Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editMaterialForm" action="Controller/edit_course_material.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="editMaterialId">
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
                                $selected = $course['id'] == $material['course_id'] ? 'selected' : '';
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
                        <label for="editFile" class="form-label">Upload File</label>
                        <input type="file" class="form-control" id="editFile" name="file">
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Material Modal -->
<div class="modal fade" id="deleteMaterialModal" tabindex="-1" aria-labelledby="deleteMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMaterialModalLabel">Delete Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this material?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteMaterialForm" action="Controller/delete_course_material.php" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" id="deleteMaterialId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function setEditModalData(material) {
        document.getElementById('editMaterialId').value = material.id;
        document.getElementById('editCourseId').value = material.course_id;
        document.getElementById('editTitle').value = material.title;
        document.getElementById('editContent').value = material.content;
        document.getElementById('editExistingFilePath').value = material.file_path; // Ensure this line sets the existing file path
        // You may need to handle file input differently
    }

    function setDeleteModalData(id) {
        document.getElementById('deleteMaterialId').value = id;
    }
</script>

<?php
$conn->close();
?>
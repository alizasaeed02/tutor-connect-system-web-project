<!-- Row start -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <!-- Display success or error messages -->
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert <?php echo $_SESSION['message_class']; ?>">
                        <?php echo $_SESSION['message']; unset($_SESSION['message'], $_SESSION['message_class']); ?>
                    </div>
                <?php endif; ?>

                <!-- Create Section Button -->
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createSectionModal">Create Section</button>
                
                <!-- Sections Table -->
                <div class="table-responsive">
                    <table class="table align-middle table-hover m-0">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                        <td>
                                            <!-- Edit Button -->
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editSectionModal" onclick="setEditModalData(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <!-- Delete Button -->
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteSectionModal" onclick="setDeleteModalData(<?php echo $row['id']; ?>)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">No sections found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Section Modal -->
<div class="modal fade" id="createSectionModal" tabindex="-1" aria-labelledby="createSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSectionModalLabel">Create Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createSectionForm" action="Controller/create_section.php" method="POST">
                    <input type="hidden" name="action" value="create">
                    <div class="mb-3">
                        <label for="createName" class="form-label">Section Name</label>
                        <input type="text" class="form-control" id="createName" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Section</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Section Modal -->
<div class="modal fade" id="editSectionModal" tabindex="-1" aria-labelledby="editSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSectionModalLabel">Edit Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSectionForm" action="Controller/edit_section.php" method="POST">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="editSectionId">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Section Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Section Modal -->
<div class="modal fade" id="deleteSectionModal" tabindex="-1" aria-labelledby="deleteSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSectionModalLabel">Delete Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this section?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteSectionForm" action="Controller/delete_section.php" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" id="deleteSectionId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Set data for Edit Modal
    function setEditModalData(section) {
        document.getElementById('editSectionId').value = section.id;
        document.getElementById('editName').value = section.name;
    }

    // Set data for Delete Modal
    function setDeleteModalData(id) {
        document.getElementById('deleteSectionId').value = id;
    }
</script>

<?php
$conn->close();
?>

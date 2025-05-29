<!-- Row start -->
<div class="row justify-content-center">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <!-- Row start -->
                <div class="row align-items-center">
                    <div class="col-auto">
                        <img src="../assets/uploads/<?php echo htmlspecialchars($user['profile_photo']); ?>" class="img-5xx rounded-circle" alt="Profile Photo" />
                    </div>
                    <div class="col">
                        <h6 class="text-primary">
                            <?php 
                                switch ($_SESSION['role_id']) {
                                    case 1:
                                        echo htmlspecialchars('Student');
                                        break;
                                    case 2:
                                        echo htmlspecialchars('Tutor');
                                        break;
                                    case 3:
                                        echo htmlspecialchars('Administrator');
                                        break;
                                    case 4:
                                        echo htmlspecialchars('Parent');
                                        break;
                                    default:
                                        echo htmlspecialchars('');
                                        break;
                                }
                            ?>
                        </h6>
                        <h4 class="m-0"><?php echo htmlspecialchars($user['username']); ?></h4>
                    </div>
                    <div class="col-12 col-md-auto" style="display: none;">
                        <a href="#!" class="btn btn-outline-primary btn-lg">Change Password</a>
                    </div>
                </div>
                <!-- Row end -->
            </div>
        </div>
    </div>
</div>
<!-- Row end -->

<!-- User Details and Experience Section -->
<div class="row">
    <div class="col-xxl-3 col-sm-6 col-12 order-xxl-1 order-xl-2 order-lg-2 order-md-2 order-sm-2">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">About</h5>
            </div>
            <div class="card-body">
                <h6 class="d-flex align-items-center mb-3">
                    <i class="bi bi-person-square fs-2 me-2"></i> Username : 
                    <span class="text-primary"><?php echo htmlspecialchars($user['username']); ?></span>
                </h6>
                <h6 class="d-flex align-items-center mb-3">
                    <i class="bi bi-house fs-2 me-2"></i> Address :
                    <span class="text-primary">: <?php echo htmlspecialchars($user['address']); ?></span>
                </h6>
                <h6 class="d-flex align-items-center mb-3">
                    <i class="bi bi-building fs-2 me-2"></i> Phone :
                    <span class="text-primary"><?php echo htmlspecialchars($user['phone']); ?></span>
                </h6>
                <h6 class="d-flex align-items-center mb-3">
                    <i class="bi bi-send fs-2 me-2"></i> Email :
                    <span class="text-primary"><?php echo htmlspecialchars($user['email']); ?></span>
                </h6>
            </div>
        </div>
    </div>
    <div class="col-xxl-9 col-sm-12 col-12 order-xxl-2 order-xl-1 order-lg-1 order-md-1 order-sm-1">
        <!-- Row start -->
        <div class="card mb-4">
            <form action="Controller/profile_update.php" method="POST" enctype="multipart/form-data">
                <div class="card-header">
                    <h4 class="card-title mb-3">Details</h4>
                </div>
                <div class="card-body">
                    <!-- Row start -->
                    <div class="row">
                        <div class="col-lg-4 col-sm-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">User Name</label>
                                <input type="text" class="form-control" name="username" placeholder="Enter UserName" value="<?php echo htmlspecialchars($user['username']); ?>" required/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter email address" value="<?php echo htmlspecialchars($user['email']); ?>" required/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="number" class="form-control" name="phone" placeholder="Enter phone number" value="<?php echo htmlspecialchars($user['phone']); ?>" required/>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="mb-3">
                                <label class="form-label">Profile Photo</label>
                                <input class="form-control" type="file" name="profile_photo">
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" placeholder="Enter Address" rows="3" required><?php echo htmlspecialchars($user['address']); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Row end -->
                </div>
                <div class="card-footer">
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Row end -->

        <!-- Experience Form and Table -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-3">Add Experience</h4>
                <!-- Trigger button for modal -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addExperienceModal">
                    Add Experience
                </button>
            </div>
        </div>

        <!-- Experience Table -->
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title mb-3">Experience List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Job Title</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($exp = $exp_result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($exp['company_name']); ?></td>
                                    <td><?php echo htmlspecialchars($exp['job_title']); ?></td>
                                    <td><?php echo htmlspecialchars($exp['start_date']); ?></td>
                                    <td><?php echo htmlspecialchars($exp['end_date']); ?></td>
                                    <td><?php echo htmlspecialchars($exp['description']); ?></td>
                                    <td>
                                        <!-- Actions (Edit/Delete) -->
                                        <button type="button" class="btn btn-sm btn-primary btn-edit-experience" data-experience='<?php echo json_encode($exp); ?>'>Edit</button>
                                        <button type="button" class="btn btn-sm btn-danger btn-delete-experience" data-id="<?php echo $exp['id']; ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if ($exp_result->num_rows == 0) { ?>
                                <tr>
                                    <td colspan="6">No experiences found.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Row end -->
    </div>
</div>
<!-- Row end -->

<!-- Add Experience Modal -->
<div class="modal fade" id="addExperienceModal" tabindex="-1" aria-labelledby="addExperienceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="Controller/experience_add.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExperienceModalLabel">Add Experience</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="company_name" placeholder="Enter Company Name" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Job Title</label>
                        <input type="text" class="form-control" name="job_title" placeholder="Enter Job Title" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" placeholder="Enter Description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Experience</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Experience Modal -->
<div class="modal fade" id="editExperienceModal" tabindex="-1" aria-labelledby="editExperienceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editExperienceModalLabel">Edit Experience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editExperienceForm" action="Controller/experience_edit.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit_experience_id">
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="company_name" id="edit_company_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Job Title</label>
                        <input type="text" class="form-control" name="job_title" id="edit_job_title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" id="edit_start_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" id="edit_end_date">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="edit_description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Experience</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Experience Modal -->
<div class="modal fade" id="deleteExperienceModal" tabindex="-1" aria-labelledby="deleteExperienceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteExperienceModalLabel">Delete Experience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteExperienceForm" action="Controller/experience_delete.php" method="GET">
                <div class="modal-body">
                    <p>Are you sure you want to delete this experience?</p>
                    <input type="hidden" name="id" id="delete_experience_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete Experience</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editButtons = document.querySelectorAll('.btn-edit-experience');
        var deleteButtons = document.querySelectorAll('.btn-delete-experience');

        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var experience = JSON.parse(button.getAttribute('data-experience'));

                document.getElementById('edit_experience_id').value = experience.id;
                document.getElementById('edit_company_name').value = experience.company_name;
                document.getElementById('edit_job_title').value = experience.job_title;
                document.getElementById('edit_start_date').value = experience.start_date;
                document.getElementById('edit_end_date').value = experience.end_date;
                document.getElementById('edit_description').value = experience.description;

                var editModal = new bootstrap.Modal(document.getElementById('editExperienceModal'));
                editModal.show();
            });
        });

        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var experienceId = button.getAttribute('data-id');

                document.getElementById('delete_experience_id').value = experienceId;

                var deleteModal = new bootstrap.Modal(document.getElementById('deleteExperienceModal'));
                deleteModal.show();
            });
        });
    });

</script>

<!-- Bootstrap JS (including Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXlBZ/3w5ZqdlbI+LW2LyfZhfFiv0QG0tmUN3CpNb4zGjF5y6d9a4e4pBBw7" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9KZbSZaFV5J8z8lqI42Tn4U7hsdOVrYB/lOQK7j3cF05SNj5D5y48Yr" crossorigin="anonymous"></script>
<?php
	$user_id = $_SESSION['user_id'];

	// Fetch user details from the database
	$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
	$stmt->bind_param("i", $user_id);
	$stmt->execute();
	$user_result = $stmt->get_result();
	$user = $user_result->fetch_assoc();
	$stmt->close();

	if (!$user) {
		echo "User not found!";
		exit;
	}
?>

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

<!-- Row start -->
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
    </div>
</div>
<!-- Row end -->

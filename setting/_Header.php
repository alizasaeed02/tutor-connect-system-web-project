<?php

$user_id = $_SESSION['user_id']; // Get the logged-in user ID

// Fetch unread notifications count for the logged-in user
$sql1 = "
    SELECT COUNT(*) AS unread_count 
    FROM class_notification cn
    LEFT JOIN user_notifications un 
    ON cn.id = un.notification_id AND un.user_id = ? 
    WHERE un.is_read = 0 OR un.is_read IS NULL";

$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("i", $user_id);
$stmt1->execute();
$result1 = $stmt1->get_result();
$row1 = $result1->fetch_assoc();

$unread_count = $row1['unread_count']; // Get the count of unread notifications

$stmt1->close();

// Fetch total rows in arrange_meeting_notification (no need for user_id)
$sql2 = "
    SELECT COUNT(*) AS total_rows FROM `arrange_meeting_notification`";

$stmt2 = $conn->prepare($sql2); 
$stmt2->execute(); 
$result2 = $stmt2->get_result(); 
$row2 = $result2->fetch_assoc(); 

$unread_count_meeting = $row2['total_rows']; // Get the total count of rows in arrange_meeting_notification

$stmt2->close();
?>



<!-- App header starts -->
<div class="app-header d-flex align-items-center">

    <!-- Toggle buttons start -->
    <div class="d-flex">
        <button class="btn btn-outline-primary me-2 toggle-sidebar" id="toggle-sidebar">
            <i class="bi bi-text-indent-left fs-5"></i>
        </button>
        <button class="btn btn-outline-primary me-2 pin-sidebar" id="pin-sidebar">
            <i class="bi bi-text-indent-left fs-5"></i>
        </button>
    </div>
    <!-- Toggle buttons end -->


    <!-- App brand sm start -->
    <div class="app-brand-sm d-md-none d-sm-block">
        <a href="index.html">
            <!-- <img src="../assets/images/logo-sm.svg" class="logo" alt="Bootstrap Gallery"> -->
        </a>
    </div>
    <!-- App brand sm end -->

    <!-- App header actions start -->
    <div class="header-actions">
        <?php 
        if ($_SESSION['role_id'] == 1) { 
        ?>
        <!-- Bell Icon with unread count -->
        <div class="dropdown ms-2">
            <a class="dropdown-toggle d-flex p-2 border rounded-2" href="../Student/show_class_notification.php">
                <i class="bi bi-bell fs-4 lh-1"></i>
                <?php if ($unread_count > 0) { ?>
                    <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"><?php echo $unread_count; ?></span>
                <?php } ?>
            </a>
        </div>
        <?php } ?>

        <?php 
        if ($_SESSION['role_id'] == 2) { 
        ?>
        <!-- Bell Icon with unread count -->
        <div class="dropdown ms-2">
            <a class="dropdown-toggle d-flex p-2 border rounded-2" href="../Tutor/class_notification.php">
                <i class="bi bi-bell fs-4 lh-1"></i>
                <?php if ($unread_count > 0) { ?>
                    <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"><?php echo $unread_count; ?></span>
                <?php } ?>
            </a>
        </div>
        <?php } ?>

        <?php 
        if ($_SESSION['role_id'] == 3) { 
        ?>
        <!-- Bell Icon with unread count -->
        <div class="dropdown ms-2">
            <a class="dropdown-toggle d-flex p-2 border rounded-2" href="../Administrator/show_class_notification.php">
                <i class="bi bi-bell fs-4 lh-1"></i>
                <?php if ($unread_count > 0) { ?>
                    <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"><?php echo $unread_count; ?></span>
                <?php } ?>
            </a>
        </div>
        <?php } ?>

        <!-- Parent Notification Icon -->
        <?php if ($_SESSION['role_id'] == 4) { ?>
        <div class="dropdown ms-2">
            <a class="dropdown-toggle d-flex p-2 border rounded-2" href="../Parent/view_meeting_notification.php">
                <i class="bi bi-bell fs-4 lh-1"></i>
                <?php if ($unread_count_meeting > 0) { ?>
                    <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"><?php echo $unread_count_meeting; ?></span>
                <?php } ?>
            </a>
        </div>
        <?php } ?>
        
        <!-- <div class="dropdown ms-2">
            <a class="dropdown-toggle d-flex p-2 border rounded-2" href="#!" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi bi-bell fs-4 lh-1"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow">
                <div class="dropdown-item">
                    <div class="d-flex py-2 border-bottom">
                        <img src="../assets/images/user.png" class="img-4x me-3 rounded-3" alt="Admin Theme" />
                        <div class="m-0">
                            <h6 class="mb-1">Sophie Michiels</h6>
                            <p class="mb-2">Membership has been ended.</p>
                            <p class="small m-0 text-secondary">Today, 07:30pm</p>
                        </div>
                    </div>
                </div>
                <div class="dropdown-item">
                    <div class="d-flex py-2 border-bottom">
                        <img src="../assets/images/user2.png" class="img-4x me-3 rounded-3" alt="Admin Theme" />
                        <div class="m-0">
                            <h6 class="mb-1">Sophie Michiels</h6>
                            <p class="mb-2">Congratulate, James for new job.</p>
                            <p class="small m-0 text-secondary">Today, 08:00pm</p>
                        </div>
                    </div>
                </div>
                <div class="dropdown-item">
                    <div class="d-flex py-2">
                        <img src="../assets/images/user1.png" class="img-4x me-3 rounded-3" alt="Admin Theme" />
                        <div class="m-0">
                            <h6 class="mb-1">Sophie Michiels</h6>
                            <p class="mb-2">Lewis added new schedule release.</p>
                            <p class="small m-0 text-secondary">Today, 09:30pm</p>
                        </div>
                    </div>
                </div>
                <div class="d-grid m-3">
                    <a href="events.html" class="btn btn-primary">View all</a>
                </div>
            </div>
        </div> -->
        <div class="dropdown ms-3">
            <a id="userSettings" class="dropdown-toggle d-flex py-2 align-items-center ps-3 border-start" href="#!"
                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="d-none d-md-block me-2"><?php echo htmlspecialchars($user['username']); ?></span>
                <img src="../assets/uploads/<?php echo htmlspecialchars($user['profile_photo']); ?>" class="rounded-circle img-3x" alt="Bootstrap Gallery" />
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow">
                <a class="dropdown-item d-flex align-items-center" href="profile.php"><i
                        class="bi bi-person fs-4 me-2"></i>Profile</a>
                <a class="dropdown-item d-flex align-items-center" href="../logout.php"><i
                        class="bi bi-escape fs-4 me-2"></i>Logout</a>
            </div>
        </div>
    </div>
    <!-- App header actions end -->

</div>
<!-- App header ends -->
<?php
// Determine role title
$roleTitle = '';
switch ($_SESSION['role_id']) {
    case 1:
        $roleTitle = 'Student';
        break;
    case 2:
        $roleTitle = 'Tutor';
        break;
    case 3:
        $roleTitle = 'Admin';
        break;
    case 4:
        $roleTitle = 'Parent';
        break;
    default:
        $roleTitle = 'User'; // Default title if role_id is not recognized
        break;
}
?>

<!-- Sidebar wrapper start -->
<nav id="sidebar" class="sidebar-wrapper">

    <!-- App brand starts -->
    <div class="app-brand p-4">
        <a href="index.html">
            <h2 class="text-white"><span>Welcome <?php echo htmlspecialchars($roleTitle); ?></span></h2>
        </a>
    </div>
    <!-- App brand ends -->



    <!-- Sidebar menu starts -->
    <div class="sidebarMenuScroll">
        <ul class="sidebar-menu">
            <li>
                <?php 
                if ($_SESSION['role_id'] == 3) { 
                    ?>
                    <a href="../Administrator/admin_dashboard.php">
                        <i class="bi bi-pie-chart"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                    <?php 
                } elseif ($_SESSION['role_id'] == 2) { 
                    ?>
                    <a href="../Tutor/instructor_dashboard.php">
                        <i class="bi bi-pie-chart"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                    <?php 
                } elseif ($_SESSION['role_id'] == 1) { 
                    ?>
                    <a href="../Student/student_dashboard.php">
                        <i class="bi bi-pie-chart"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                    <?php 
                } elseif ($_SESSION['role_id'] == 4) { 
                    ?>
                    <a href="../Parent/parent_dashboard.php">
                        <i class="bi bi-pie-chart"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                    <?php 
                } else { 
                    header("Location: logout.php");
                    exit; 
                }
                ?>
            </li>
            
    <?php 
        if ($_SESSION['role_id'] == 3) { 
            ?>
            <li>
                <a href="../Administrator/user.php">
                    <i class="bi bi-person-circle"></i>
                    <span class="menu-text">All Users</span>
                </a>
            </li>
            <li>
                <a href="../Administrator/tutor.php">
                    <i class="bi bi-people"></i>
                    <span class="menu-text">Total Tutors</span>
                </a>
            </li>
            <li>
                <a href="../Administrator/student.php">
                    <i class="bi bi-person-lines-fill"></i>
                    <span class="menu-text">Total Students</span>
                </a>
            </li>
            <li>
                <a href="../Administrator/show_class_notification.php">
                    <i class="bi bi-alarm"></i>
                    <span class="menu-text">View Notification</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#!">
                    <i class="bi bi-ui-checks-grid"></i>
                    <span class="menu-text">Course &amp; Materials</span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="../Administrator/manage_section.php">Manage Section</a>
                    </li>
                    <li>
                        <a href="../Administrator/courses.php">Courses</a>
                    </li>
                    <li>
                        <a href="../Administrator/courses_assign.php">Courses Assign</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="../Administrator/pending_payment.php">
                    <i class="bi bi-currency-dollar"></i>
                    <span class="menu-text">Payment Verification</span>
                </a>
            </li>
            <li>
                <a href="../Administrator/verified_payment.php">
                    <i class="bi bi-file-earmark-check"></i>
                    <span class="menu-text">Report Verified Payment</span>
                </a>
            </li>
            <li>
                <a href="../Administrator/rejected_payment.php">
                    <i class="bi bi-file-earmark-excel"></i>
                    <span class="menu-text">Rejected Payment</span>
                </a>
            </li>
            <li>
                <a href="../Administrator/give_salary_to_tutor.php">
                    <i class="bi bi-smartwatch"></i>
                    <span class="menu-text">Tutor Salary</span>
                </a>
            </li>
            <li>
                <a href="../Administrator/students_record.php">
                    <i class="bi bi-person-lines-fill"></i>
                    <span class="menu-text">Total Students Record</span>
                </a>
            </li>
            <li>
                <a href="../Administrator/show_submitted_assignment.php">
                    <i class="bi bi-smartwatch"></i>
                    <span class="menu-text">Show Assignment/Quiz Marks</span>
                </a>
            </li>
            <li>
                <a href="../Administrator/chating_system.php">
                    <i class="bi bi-envelope"></i>
                    <span class="menu-text">Chating</span>
                </a>
            </li>
            <li>
                <a href="../Administrator/view_feedback.php">
                    <i class="bi bi-star"></i>
                    <span class="menu-text">View Feedback</span>
                </a>
            </li>
            <li>
                <a href="../Administrator/view_complaints.php">
                    <i class="bi bi-envelope-exclamation"></i>
                    <span class="menu-text">View Complaint</span>
                </a>
            </li>
    <?php } ?>
    <?php 
        if ($_SESSION['role_id'] == 2) { 
            ?>
            <li>
                <a href="../Tutor/class_notification.php">
                    <i class="bi bi-alarm"></i>
                    <span class="menu-text">Class Notification</span>
                </a>
            </li>
            <li>
                <a href="../Tutor/arrange_meeting_notification.php">
                    <i class="bi bi-calendar"></i>
                    <span class="menu-text">Arrange Metting</span>
                </a>
            </li>
            <li>
                <a href="../Tutor/deadline_materials.php">
                    <i class="bi bi-border-all"></i>
                    <span class="menu-text">Deadline Materials</span>
                </a>
            </li>
            <li>
                <a href="../Tutor/course_materials.php">
                    <i class="bi bi-arrow-up-square"></i>
                    <span class="menu-text">Course Materials</span>
                </a>
            </li>
            <li>
                <a href="../Tutor/students_record.php">
                    <i class="bi bi-person-badge"></i>
                    <span class="menu-text">Student Record</span>
                </a>
            </li>
            <li>
                <a href="../Tutor/show_submitted_assignments.php">
                    <i class="bi bi-shield-fill-check"></i>
                    <span class="menu-text">Show Submitted Results</span>
                </a>
            </li>
            <li>
                <a href="../Tutor/view_salary.php">
                    <i class="bi bi-currency-dollar"></i>
                    <span class="menu-text">View Salary</span>
                </a>
            </li>
            <!-- <li>
                <a href="../Tutor/pending_payment.php">
                    <i class="bi bi-currency-dollar"></i>
                    <span class="menu-text">Payment Verification</span>
                </a>
            </li>
            <li>
                <a href="../Tutor/verified_payment.php">
                    <i class="bi bi-file-earmark-check"></i>
                    <span class="menu-text">Verified Payment</span>
                </a>
            </li>
            <li>
                <a href="../Tutor/rejected_payment.php">
                    <i class="bi bi-file-earmark-excel"></i>
                    <span class="menu-text">Rejected Payment</span>
                </a>
            </li> -->
            <li>
                <a href="../Tutor/tutor_chat.php">
                    <i class="bi bi-envelope"></i>
                    <span class="menu-text">Chating</span>
                </a>
            </li>
            <li>
                <a href="../Tutor/view_feedback.php">
                    <i class="bi bi-star"></i>
                    <span class="menu-text">View Feedback</span>
                </a>
            </li>
            <li>
                <a href="../Tutor/submit_complaint.php">
                    <i class="bi bi-envelope-exclamation"></i>
                    <span class="menu-text">Submit Complaint</span>
                </a>
            </li>
    <?php } ?>
    <?php 
        if ($_SESSION['role_id'] == 1) { 
            ?>
            <li>
                <a href="../Student/show_class_notification.php">
                    <i class="bi bi-alarm"></i>
                    <span class="menu-text">Show Class Notification</span>
                </a>
            </li>
            <li>
                <a href="../Student/course_registration_fee.php">
                    <i class="bi bi-person-plus-fill"></i>
                    <span class="menu-text">Course Registration Fee</span>
                </a>
            </li>
            <li>
                <a href="../Student/course_registration.php">
                    <i class="bi bi-slash-square"></i>
                    <span class="menu-text">Course Registration</span>
                </a>
            </li>
            <li>
                <a href="../Student/show_course_deadline_materials.php">
                    <i class="bi bi-arrow-down-square"></i>
                    <span class="menu-text">Show Course Deadline Materials</span>
                </a>
            </li>
            <li>
                <a href="../Student/show_course_materials.php">
                    <i class="bi bi-arrow-down-square-fill"></i>
                    <span class="menu-text">Show Course Materials</span>
                </a>
            </li>
            <li>
                <a href="../Student/submit_assignment.php">
                    <i class="bi bi-smartwatch"></i>
                    <span class="menu-text">Submit Assignment</span>
                </a>
            </li>
            <li>
                <a href="../Student/show_submitted_assignment.php">
                    <i class="bi bi-smartwatch"></i>
                    <span class="menu-text">Show Assignment/Quiz Marks</span>
                </a>
            </li>
            <li>
                <a href="../Student/student_chat.php">
                    <i class="bi bi-envelope"></i>
                    <span class="menu-text">Chating</span>
                </a>
            </li>
            <li>
                <a href="../Student/submit_feedback.php">
                    <i class="bi bi-star"></i>
                    <span class="menu-text">Submit Feedback</span>
                </a>
            </li>
            <li>
                <a href="../Student/submit_complaint.php">
                    <i class="bi bi-envelope-exclamation"></i>
                    <span class="menu-text">Submit Complaint</span>
                </a>
            </li>
    <?php } ?>
    <?php 
        if ($_SESSION['role_id'] == 4) { 
            ?>
            <li>
                <a href="../Parent/parent_chat.php">
                    <i class="bi bi-chat-dots"></i>
                    <span class="menu-text">Chat with Tutor</span>
                </a>
            </li>
            <li>
                <a href="../Parent/view_child_results.php">
                    <i class="bi bi-file-earmark-text"></i>
                    <span class="menu-text">View Result of Child</span>
                </a>
            </li>
            <li>
                <a href="../Parent/view_meeting_notification.php">
                    <i class="bi bi-calendar"></i>
                    <span class="menu-text">Attend Meeting</span>
                </a>
            </li>
            <li>
                <a href="../Parent/submit_complaint.php">
                    <i class="bi bi-envelope-exclamation"></i>
                    <span class="menu-text">Submit Complaint</span>
                </a>
            </li>

    <?php } ?>
        </ul>
    </div>

    <!-- Sidebar menu ends -->

</nav>
<!-- Sidebar wrapper end -->
<!-- Start DataTables Code .css -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<style>
    /* Custom button styles */
    .dt-buttons .dt-button {
        margin: 0 5px;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #007bff;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }
    .dt-buttons .dt-button:hover {
        background-color: #0056b3;
    }
    .dt-buttons .dt-button.print {
        background-color: #28a745;
    }
    .dt-buttons .dt-button.print:hover {
        background-color: #218838;
    }
    .dt-buttons .dt-button.excel {
        background-color: #007bff;
    }
    .dt-buttons .dt-button.excel:hover {
        background-color: #0056b3;
    }
</style>
<!-- End Data Table Code .css -->


<?php
    session_start();
    require '../Database/config.php';

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }

    // Fetch user data
    $user = getUserData($_SESSION['user_id']);

    $title = "Student Record";

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }

    // Fetch user data with roles
    $user_id = $_SESSION['user_id']; // Assuming you have the user ID in session

    // Start: Fetch courses assigned to the instructor
    $sql = "SELECT course_instructor_assigned.*, courses.name AS course_name, courses.id AS course_id 
            FROM course_instructor_assigned 
            JOIN courses ON course_instructor_assigned.course_id = courses.id";
    $course_result = $conn->query($sql);
    // End: Fetch courses assigned to the instructor

    $course_id = isset($_POST['course_id']) ? $_POST['course_id'] : null;

    $result = null;
    if ($course_id) {
        // Fetch registered users for the selected course
        $sql = "SELECT course_registration.*, users.username, users.email, users.address, users.phone, users.profile_photo, users.created_at, roles.name AS role_name
                FROM course_registration
                JOIN users ON course_registration.user_id = users.id
                JOIN roles ON users.role_id = roles.id
                WHERE course_registration.course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    }

    $content = "../Administrator/students_record_content.php";
    include '../setting/_Layout.php';

?>

<!-- Start: the below for datatable -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    className: 'btn btn-excel'
                },
                {
                    extend: 'print',
                    text: 'Print',
                    className: 'btn btn-print'
                }
            ],
            scrollX: true,
            pageLength: 100,
            lengthMenu: [ [100, 200, 300, 400, 500], [100, 200, 300, 400, 500] ]
        });
    });
</script>
<!-- End: the below for datatable -->
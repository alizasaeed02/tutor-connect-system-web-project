<!-- Row starts -->
 <html>
    <head>
        <title>welcome admin</title>
    </head>
    <body>
    <h1 style="text-align: center; color: #4CAF50; font-family: Arial, sans-serif; margin-top: 20px; font-size: 60px; line-height: 1.5;">Welcome, Admin!</h1>
    </body>
<div class="row">
    <div class="col-xxl-3 col-sm-6 col-12">
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center p-0">
                <div class="p-4">
                    <i class="bi bi-pie-chart fs-1 lh-1 text-primary"></i>
                </div>
                <div class="py-4">
                    <h5 class="text-secondary fw-light m-0">All Users</h5>
                    <h1 class="m-0"><?php echo $total_users; ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6 col-12">
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center p-0">
                <div class="p-4">
                    <i class="bi bi-sticky fs-1 lh-1 text-primary"></i>
                </div>
                <div class="py-4">
                    <h5 class="text-secondary fw-light m-0">All Students</h5>
                    <h1 class="m-0"><?php echo $total_students; ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6 col-12">
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center p-0">
                <div class="p-4">
                    <i class="bi bi-emoji-smile fs-1 lh-1 text-primary"></i>
                </div>
                <div class="py-4">
                    <h5 class="text-secondary fw-light m-0">All Instructors</h5>
                    <h1 class="m-0"><?php echo $total_instructors; ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6 col-12">
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center p-0">
                <div class="p-4">
                    <i class="bi bi-star fs-1 lh-1 text-danger"></i>
                </div>
                <div class="py-4">
                    <h5 class="text-secondary fw-light m-0">All Courses</h5>
                    <h1 class="m-0 text-danger"><?php echo $total_courses; ?></h1>
                </div>
            </div>
        </div>
    </div>

    
</div>
<!-- Row ends -->

<?php
$conn->close();
?>
</html>
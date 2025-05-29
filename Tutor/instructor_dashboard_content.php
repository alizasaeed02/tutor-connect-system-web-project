<!-- Row starts -->
<div class="row">
    <div class="col-xxl-3 col-sm-6 col-12">
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center p-0">
                <div class="p-4">
                    <i class="bi bi-bookmark-check fs-1 lh-1 text-primary"></i>
                </div>
                <div class="py-4">
                    <h5 class="text-secondary fw-light m-0">Assigned Courses</h5>
                    <h1 class="m-0"><?php echo htmlspecialchars($total_courses); ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6 col-12">
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center p-0">
                <div class="p-4">
                    <i class="bi bi-person-check fs-1 lh-1 text-primary"></i>
                </div>
                <div class="py-4">
                    <h5 class="text-secondary fw-light m-0">Total Students</h5>
                    <h1 class="m-0"><?php echo htmlspecialchars($total_students); ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6 col-12">
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center p-0">
                <div class="p-4">
                    <i class="bi bi-file-earmark-text fs-1 lh-1 text-primary"></i>
                </div>
                <div class="py-4">
                    <h5 class="text-secondary fw-light m-0">Total Assignments</h5>
                    <h1 class="m-0"><?php echo htmlspecialchars($total_assignments); ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6 col-12">
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center p-0">
                <div class="p-4">
                    <i class="bi bi-question-circle fs-1 lh-1 text-primary"></i>
                </div>
                <div class="py-4">
                    <h5 class="text-secondary fw-light m-0">Total Quizzes</h5>
                    <h1 class="m-0"><?php echo htmlspecialchars($total_quizzes); ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row ends -->

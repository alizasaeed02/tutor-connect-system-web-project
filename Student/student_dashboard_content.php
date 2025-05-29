<!-- Row starts -->
<div class="row">
    <div class="col-xxl-3 col-sm-6 col-12">
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center p-0">
                <div class="p-4">
                    <i class="bi bi-book fs-1 lh-1 text-primary"></i>
                </div>
                <div class="py-4">
                    <h5 class="text-secondary fw-light m-0">Courses Registered</h5>
                    <h1 class="m-0"><?php echo htmlspecialchars($total_courses); ?></h1>
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
                    <h5 class="text-secondary fw-light m-0">Assignments Submitted</h5>
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
                    <h5 class="text-secondary fw-light m-0">Total Quizzes Submitted</h5>
                    <h1 class="m-0"><?php echo htmlspecialchars($total_quizzes); ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6 col-12">
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center p-0">
                <div class="p-4">
                    <i class="bi bi-play-btn fs-1 lh-1 text-primary"></i>
                </div>
                <div class="py-4">
                    <h5 class="text-secondary fw-light m-0">Total Lectures</h5>
                    <h1 class="m-0"><?php echo htmlspecialchars($total_lectures); ?></h1>
                </div>
            </div>
        </div>
    </div>

    <h5 class="fw-semibold mb-4 text-center color-red">You Have 2 Notification</h5>
</div>
<!-- Row ends -->

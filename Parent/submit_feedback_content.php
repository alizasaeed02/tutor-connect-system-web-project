<!-- Row start for feedback form -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Submit Feedback for a Course</h5>
                <form method="POST" action="Controller/process_feedback.php">
                    <div class="form-group">
                        <label for="courseSelect">Select Course:</label>
                        <select id="courseSelect" name="course_id" class="form-control" required>
                            <option value="">-- Select Course --</option>
                            <?php
                            while ($course = $result->fetch_assoc()) {
                                echo "<option value=\"" . htmlspecialchars($course['id']) . "\">" . htmlspecialchars($course['name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="rating">Rating (1-5):</label>
                        <input type="number" id="rating" name="rating" min="1" max="5" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="comments">Comments:</label>
                        <textarea id="comments" name="comments" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Row end for feedback form -->

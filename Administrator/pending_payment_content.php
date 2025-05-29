<!-- Row start -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table align-middle table-hover m-0 display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Course Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Transaction No</th>
                                <th scope="col">Receipt</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $file_path = '../assets/uploads/receipts/' . $row['receipt_path'];
                            ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                                        <td><?php echo htmlspecialchars($row['transaction_no']); ?></td>
                                        <td>
                                            <?php if (!empty($row['receipt_path']) && file_exists($file_path)) { ?>
                                                <a href="<?php echo htmlspecialchars($file_path); ?>" class="btn btn-sm btn-secondary" download>
                                                    Download
                                                </a>
                                            <?php } else {
                                                echo '';
                                            } ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['payment_status']); ?></td>
                                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                        <td>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#verifyPaymentModal" onclick="setVerifyModalData(<?php echo $row['id']; ?>)"><i class="bi bi-check-circle"></i> Verify</button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectPaymentModal" onclick="setRejectModalData(<?php echo $row['id']; ?>)"><i class="bi bi-x-circle"></i> Reject</button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="7">No Course Registration found.</td>
                                </tr>
                            <?php
                            }
                            $stmt->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->

<!-- Verify Payment Modal -->
<div class="modal fade" id="verifyPaymentModal" tabindex="-1" aria-labelledby="verifyPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifyPaymentModalLabel">Verify Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to verify this payment?</p>
            </div>
            <div class="modal-footer">
                <form id="verifyPaymentForm" action="Controller/verify_payment.php" method="POST">
                    <input type="hidden" name="action" value="verify">
                    <input type="hidden" name="id" id="verifyPaymentId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Verify</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reject Payment Modal -->
<div class="modal fade" id="rejectPaymentModal" tabindex="-1" aria-labelledby="rejectPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectPaymentModalLabel">Reject Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reject this payment?</p>
            </div>
            <div class="modal-footer">
                <form id="rejectPaymentForm" action="Controller/reject_payment.php" method="POST">
                    <input type="hidden" name="action" value="reject">
                    <input type="hidden" name="id" id="rejectPaymentId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function setVerifyModalData(id) {
        document.getElementById('verifyPaymentId').value = id;
    }

    function setRejectModalData(id) {
        document.getElementById('rejectPaymentId').value = id;
    }
</script>

<?php
$conn->close();
?>

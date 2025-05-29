<!-- Row start -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">

                <!-- Date Range Filter Form -->
                <form method="GET" action="verified_payment.php" class="mb-3">
                    <div class="row">
                        <label for="from_date" class="form-label">Generate Report</label>
                        <div class="col-md-5">
                            <label for="from_date" class="form-label">From Date:</label>
                            <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo htmlspecialchars($from_date); ?>">
                        </div>
                        <div class="col-md-5">
                            <label for="to_date" class="form-label">To Date:</label>
                            <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo htmlspecialchars($to_date); ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary m-2">Filter</button>
                        </div>
                    </div>
                </form>

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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalAmount = 0; // Initialize total amount
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $file_path = '../assets/uploads/receipts/' . $row['receipt_path'];
                                    $totalAmount += $row['price']; // Add to total amount
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
                                        <td>
                                            <a class="btn btn-sm btn-success">
                                                <?php echo htmlspecialchars($row['payment_status']); ?>
                                            </a>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="6">No Course Registration found.</td>
                                </tr>
                            <?php
                            }
                            $stmt->close();
                            ?>
                            <tr>
                                <td class="text-end fw-bold">Total Amount:</td>
                                <td class="fw-bold"><?php echo htmlspecialchars($totalAmount); ?></td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->


<?php
$conn->close();
?>

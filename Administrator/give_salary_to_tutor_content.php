<!-- Row start -->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-body">
                <!-- Create Transaction Button -->
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createTransactionModal">Create Transaction</button>
                <div class="table-responsive">
                    <table id="example" class="table align-middle table-hover m-0 display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Tutor Name</th>
                                <th scope="col">Salary Amount</th>
                                <!-- <th scope="col">Payment Status</th> -->
                                <th scope="col">Payment Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($transactionResult->num_rows > 0) {
                                while ($row = $transactionResult->fetch_assoc()) {
                                    $transaction_id = $row['id'];
                                    $tutor_name = $row['username'];
                                    $salary_amount = $row['amount'];
                                    // $payment_status = $row['payment_status'];
                                    $payment_date = $row['payment_date'];
                            ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($tutor_name); ?></td>
                                        <td><?php echo htmlspecialchars($salary_amount); ?></td>
                                        <!-- <td>
                                            <span class="badge <?php echo ($payment_status == 'Paid') ? 'bg-success' : 'bg-warning'; ?>">
                                                <?php echo htmlspecialchars($payment_status); ?>
                                            </span>
                                        </td> -->
                                        <td><?php echo htmlspecialchars($payment_date); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTransactionModal" 
                                                    data-bs-id="<?php echo $transaction_id; ?>">Delete</button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="4">No transaction records found.</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->

<!-- Create Transaction Modal -->
<div class="modal fade" id="createTransactionModal" tabindex="-1" aria-labelledby="createTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTransactionModalLabel">Create Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createTransactionForm" action="Controller/give_salary_to_tutor_action.php" method="POST">
                    <input type="hidden" name="action" value="create">
                    
                    <div class="mb-3">
                        <label for="transactionTutor" class="form-label">Tutor</label>
                        <select class="form-select" name="tutor_id" id="transactionTutor" required>
                            <?php
                            while ($tutorRow = $tutorResult->fetch_assoc()) {
                                echo "<option value='" . $tutorRow['tutor_id'] . "'>" . htmlspecialchars($tutorRow['tutor_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="transactionAmount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" name="amount" id="transactionAmount" required>
                    </div>
                    <div class="mb-3">
                        <label for="transactionDate" class="form-label">Payment Date</label>
                        <input type="date" class="form-control" name="payment_date" id="transactionDate" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Create Transaction</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Transaction Modal -->
<div class="modal fade" id="deleteTransactionModal" tabindex="-1" aria-labelledby="deleteTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTransactionModalLabel">Delete Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this transaction?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteTransactionForm" action="Controller/delete_transaction.php" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" id="deleteTransactionId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Set transaction ID for deletion in the Delete Transaction modal
    var deleteButtons = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#deleteTransactionModal"]');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var transactionId = this.getAttribute('data-bs-id');
            document.getElementById('deleteTransactionId').value = transactionId;
        });
    });
</script>

<?php
$conn->close();
?>
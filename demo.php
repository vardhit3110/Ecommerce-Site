<div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fa-solid fa-arrows-rotate"></i> Update Order Status</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Select New Status :- </label>
                    <div class="d-flex align-items-center">

                        <select id="newStatus" class="form-select">
                            <option value="">-- Select Status --</option>
                            <option value="1">Pending</option>
                            <option value="2">Processing</option>
                            <option value="3">Shipped</option>
                            <option value="4">Delivered</option>
                            <option value="5">Cancelled</option>
                        </select>
                    </div>
                </div>
                <hr>
                <p><strong>Username:</strong> <span id="statusUsername"></span></p>
                <p><strong>Order ID:</strong> <span id="statusOrderId"></span></p>

                <div class="text-center">
                    <button id="updateStatusBtn" class="btn btn-success">
                        <i class="fa-solid fa-floppy-disk"></i> Update Status
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white"><i class="fa-solid fa-receipt"></i> Order Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="orderDetailsBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-dark"></div>
                    <p class="mt-2">Loading order details...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Open Status Modal with data
    $(document).on('click', '.update-status-btn', function () {
        let username = $(this).data('username');
        let orderCode = $(this).data('ordercode');
        let orderId = $(this).data('id');

        $('#statusUsername').text(username);
        $('#statusOrderId').text(orderCode);
        $('#updateStatusBtn').data('id', orderId);
    });

    // Update Status
    $('#updateStatusBtn').click(function () {
        let orderId = $(this).data('id');
        let newStatus = $('#newStatus').val();

        if (newStatus === "") {
            alert("Please select a status first.");
            return;
        }

        $.ajax({
            url: './partials/update_order_status.php',
            type: 'POST',
            data: { order_id: orderId, status: newStatus },
            success: function (response) {
                alert(response);
                location.reload();
            },
            error: function () {
                alert("Error updating status.");
            }
        });
    });

    $(document).on('click', '.view-btn', function () {
        let orderId = $(this).data('id');
        $('#orderDetailsBody').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-dark"></div>
                    <p class="mt-2">Loading order details...</p>
                </div>
            `);
        $.ajax({
            url: 'fetch_order_details.php',
            type: 'POST',
            data: { order_id: orderId },
            success: function (response) {
                $('#orderDetailsBody').html(response);
            },
            error: function () {
                $('#orderDetailsBody').html('<p class="text-danger text-center">Error loading details.</p>');
            }
        });
    });
</script>



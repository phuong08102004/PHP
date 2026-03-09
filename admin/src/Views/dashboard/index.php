<h3>Dashboard</h3>

<div class="row">
    <div class="col-md-4">
        <div class="card p-3">
            <h5>Tổng Users</h5>
            <h2><?= $totalUsers ?></h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <h5>Tổng Đơn hàng</h5>
             <h2 class="fw-bold"><?= isset($totalOrders) ? $totalOrders : 0 ?></h2>
        </div>
    </div>
</div>

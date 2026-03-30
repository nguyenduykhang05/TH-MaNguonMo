<?php
$pageTitle = 'Dashboard';
$chartLabels = array_column($chartData ?? [], 'label');
$chartValues = array_column($chartData ?? [], 'value');
ob_start();
?>
<style>
/* Clean Minimalist Layout Overrides */
.stats-grid-clean { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 24px; }
.stat-card-clean {
    background: white; border-radius: 12px; padding: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03); border: 1px solid #f8fafc;
    display: flex; flex-direction: column; gap: 10px;
}
.stat-card-clean .stat-label { font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
.stat-card-clean .stat-number { font-size: 2.4rem; font-weight: 800; color: #0f172a; line-height: 1; }
.stat-card-clean .stat-trend { font-size: 0.8rem; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; margin-top: 4px; }
.trend-up { color: #10b981; } 

.chart-grid { display: grid; grid-template-columns: 1.8fr 1.2fr; gap: 24px; margin-bottom: 24px; }
.admin-card-clean {
    background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    border: 1px solid #f8fafc; overflow: hidden; display: flex; flex-direction: column;
}
.admin-card-clean-header {
    padding: 24px 24px 0; font-size: 1.1rem; font-weight: 700; color: #1e293b;
}
.chart-container-inner { padding: 24px; flex: 1; position: relative; min-height: 320px; }
</style>

<!-- Top Stats -->
<div class="stats-grid-clean">
    <div class="stat-card-clean">
        <div class="stat-label">Tổng Sản Phẩm</div>
        <div class="stat-number"><?php echo number_format($totalProducts); ?></div>
        <div class="stat-trend trend-up">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
            Tăng ổn định
        </div>
    </div>
    <div class="stat-card-clean">
        <div class="stat-label">Tổng Danh Mục</div>
        <div class="stat-number"><?php echo number_format($totalCategories); ?></div>
        <div class="stat-trend trend-up">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
            Quản lý tốt
        </div>
    </div>
    <div class="stat-card-clean">
        <div class="stat-label">Khách Hàng</div>
        <div class="stat-number"><?php echo number_format($totalUsers); ?></div>
        <div class="stat-trend trend-up">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
            +12% tháng này
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="chart-grid">
    <div class="admin-card-clean">
        <div class="admin-card-clean-header">Phân Bổ Sản Phẩm Theo Danh Mục</div>
        <div class="chart-container-inner">
            <canvas id="barChart"></canvas>
        </div>
    </div>
    <div class="admin-card-clean">
        <div class="admin-card-clean-header">Tỉ Trọng Sản Phẩm</div>
        <div class="chart-container-inner" style="display:flex; justify-content:center; align-items:center;">
            <canvas id="donutChart"></canvas>
        </div>
    </div>
</div>

<!-- Table Row -->
<div class="admin-card-clean" style="margin-bottom: 30px;">
    <div class="admin-card-clean-header" style="display:flex; justify-content:space-between; align-items:center; padding-bottom: 20px; border-bottom: 1px solid #f1f5f9;">
        <span style="font-weight: 700;">Danh Sách Mới Nhất</span>
        <a href="<?php echo BASE_URL; ?>/Admin/products" class="btn-add" style="margin-top: -5px; background: #0f172a;">
            + Thêm sản phẩm
        </a>
    </div>
    <table class="admin-table" style="background: transparent;">
        <thead>
            <tr>
                <th style="background: transparent; border-bottom: 1px solid #f1f5f9; padding: 16px 24px;">Ảnh</th>
                <th style="background: transparent; border-bottom: 1px solid #f1f5f9;">Tên sản phẩm</th>
                <th style="background: transparent; border-bottom: 1px solid #f1f5f9;">Danh mục</th>
                <th style="background: transparent; border-bottom: 1px solid #f1f5f9;">Giá</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentProducts as $row): ?>
            <tr style="border-bottom: 1px solid #f8fafc;">
                <td style="padding: 12px 24px;"><img src="<?php echo htmlspecialchars($row['image'] ?? ''); ?>" alt="" onerror="this.style.display='none'" style="border-radius: 8px;"></td>
                <td style="font-weight:600; color:#1e293b;">
                    <?php echo htmlspecialchars($row['name']); ?>
                </td>
                <td><span style="color:#64748b; font-size: 0.9rem; font-weight: 500;"><?php echo htmlspecialchars($row['category_name'] ?? 'N/A'); ?></span></td>
                <td style="font-weight:700; color:#0f172a;"><?php echo number_format($row['price'], 0, ',', '.'); ?>đ</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    Chart.defaults.font.family = "'Inter', 'Segoe UI', Roboto, sans-serif";
    Chart.defaults.color = '#64748b';

    const labels = <?php echo json_encode($chartLabels); ?>;
    const values = <?php echo json_encode($chartValues); ?>;

    // Palette picked directly from the user's reference image
    const multiColors = [
        '#0f766e', // Teal structure
        '#166534', // Dark green structure
        '#f59e0b', // Amber
        '#b91c1c', // Crimson
        '#1d4ed8', // Dark blue
        '#6d28d9'  // Violet
    ];
    
    // 1. BAR CHART
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Số lượng',
                data: values,
                backgroundColor: multiColors,
                borderRadius: 6,
                borderSkipped: false,
                barPercentage: 0.6,
                categoryPercentage: 0.8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(241, 245, 249, 1)', drawBorder: false },
                    ticks: { padding: 10, font: {weight: '600'}, stepSize: 1 }
                },
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: { padding: 10, font: {weight: '600'}, color: '#475569' }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: { 
                    backgroundColor: '#1e293b', 
                    padding: 12, cornerRadius: 8, 
                    titleFont: {size: 14}, bodyFont: {size: 14, weight: '600'} 
                }
            }
        }
    });

    // 2. DONUT CHART
    const ctxDonut = document.getElementById('donutChart').getContext('2d');
    new Chart(ctxDonut, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: multiColors,
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%', // Thin donut
            plugins: {
                legend: {
                    position: 'right', // Place legend to the right like the photo
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        font: { size: 13, weight: '500' }
                    }
                },
                tooltip: { 
                    backgroundColor: '#1e293b', 
                    padding: 12, cornerRadius: 8
                }
            }
        }
    });
});
</script>

<?php
$adminContent = ob_get_clean();
include 'app/views/admin/layout.php';
?>

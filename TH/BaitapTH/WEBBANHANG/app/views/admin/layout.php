<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - KhangStore</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
    <style>
        *{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Inter',sans-serif;background:#f1f5f9;color:#334155;display:flex;min-height:100vh;}
        a{text-decoration:none;color:inherit;}
        
        /* Sidebar */
        .admin-sidebar{
            width:240px;flex-shrink:0;background:linear-gradient(180deg,#1e293b 0%,#0f172a 100%);
            color:#94a3b8;display:flex;flex-direction:column;position:sticky;top:0;height:100vh;
        }
        .admin-logo{
            padding:24px 20px;border-bottom:1px solid rgba(255,255,255,0.08);
            display:flex;align-items:center;gap:12px;
        }
        .admin-logo .logo-icon{
            width:40px;height:40px;background:#d70018;border-radius:10px;
            display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:1.2rem;
        }
        .admin-logo .logo-text{font-size:1.1rem;font-weight:700;color:white;}
        .admin-logo .logo-sub{font-size:0.75rem;color:#64748b;}

        .admin-nav{flex:1;padding:16px 0;}
        .nav-section-label{
            padding:8px 20px;font-size:0.7rem;font-weight:600;
            text-transform:uppercase;letter-spacing:1px;color:#475569;margin-top:8px;
        }
        .admin-nav a{
            display:flex;align-items:center;gap:12px;padding:10px 20px;
            font-size:0.9rem;font-weight:500;border-left:3px solid transparent;
            transition:all 0.2s;color:#94a3b8;
        }
        .admin-nav a:hover{background:rgba(255,255,255,0.06);color:white;border-left-color:#d70018;}
        .admin-nav a.active{background:rgba(215,0,24,0.15);color:white;border-left-color:#d70018;}
        .admin-nav a svg{opacity:0.7;flex-shrink:0;}
        .admin-nav a.active svg, .admin-nav a:hover svg{opacity:1;}

        .admin-sidebar-footer{
            padding:16px 20px;border-top:1px solid rgba(255,255,255,0.08);
            display:flex;align-items:center;gap:10px;
        }
        .admin-avatar{
            width:36px;height:36px;background:#d70018;border-radius:50%;
            display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:1rem;
        }
        .admin-user-info{flex:1;}
        .admin-user-name{font-size:0.85rem;color:white;font-weight:600;}
        .admin-user-role{font-size:0.75rem;color:#64748b;}

        /* Main content area */
        .admin-main{flex:1;display:flex;flex-direction:column;overflow:hidden;}
        .admin-topbar{
            background:white;padding:0 24px;height:64px;display:flex;align-items:center;
            justify-content:space-between;border-bottom:1px solid #e2e8f0;
            position:sticky;top:0;z-index:10;box-shadow:0 1px 3px rgba(0,0,0,0.05);
        }
        .topbar-title{font-size:1.2rem;font-weight:700;color:#1e293b;}
        .topbar-actions{display:flex;align-items:center;gap:12px;}
        .topbar-actions a{
            display:flex;align-items:center;gap:6px;padding:8px 14px;border-radius:8px;
            font-size:0.875rem;font-weight:500;transition:all 0.2s;
        }
        .btn-view-site{background:#f1f5f9;color:#334155;}
        .btn-view-site:hover{background:#e2e8f0;}
        .btn-logout{background:#fef2f2;color:#dc2626;}
        .btn-logout:hover{background:#fee2e2;}
        
        .admin-content{flex:1;padding:24px;overflow-y:auto;}

        /* Stats Cards */
        .stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:28px;}
        .stat-card{
            background:white;border-radius:12px;padding:20px 24px;
            box-shadow:0 1px 3px rgba(0,0,0,0.05);border:1px solid #f1f5f9;
            display:flex;align-items:center;gap:16px;
        }
        .stat-icon{
            width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;
        }
        .stat-icon.red{background:#fef2f2;color:#d70018;}
        .stat-icon.blue{background:#eff6ff;color:#2563eb;}
        .stat-icon.green{background:#f0fdf4;color:#16a34a;}
        .stat-number{font-size:1.8rem;font-weight:800;color:#1e293b;line-height:1;}
        .stat-label{font-size:0.875rem;color:#64748b;margin-top:4px;}

        /* Tables */
        .admin-card{
            background:white;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.05);
            border:1px solid #f1f5f9;overflow:hidden;margin-bottom:24px;
        }
        .admin-card-header{
            padding:16px 20px;border-bottom:1px solid #f1f5f9;
            display:flex;justify-content:space-between;align-items:center;
        }
        .admin-card-header h3{font-size:1rem;font-weight:700;color:#1e293b;}
        .admin-table{width:100%;border-collapse:collapse;}
        .admin-table th{
            padding:12px 16px;text-align:left;font-size:0.8rem;font-weight:600;
            text-transform:uppercase;letter-spacing:0.05em;color:#64748b;background:#f8fafc;
            border-bottom:1px solid #e2e8f0;
        }
        .admin-table td{padding:14px 16px;border-bottom:1px solid #f1f5f9;font-size:0.9rem;color:#374151;vertical-align:middle;}
        .admin-table tr:last-child td{border-bottom:none;}
        .admin-table tr:hover td{background:#fafafa;}
        .admin-table img{width:44px;height:44px;object-fit:contain;border-radius:6px;border:1px solid #f1f5f9;background:#f8fafc;}

        /* Badges */
        .badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:0.78rem;font-weight:600;}
        .badge-red{background:#fef2f2;color:#dc2626;}
        .badge-blue{background:#eff6ff;color:#2563eb;}
        .badge-green{background:#f0fdf4;color:#16a34a;}
        .badge-gray{background:#f8fafc;color:#64748b;}

        /* Buttons in table */
        .tbl-btn{
            display:inline-flex;align-items:center;gap:5px;padding:5px 12px;
            border-radius:6px;font-size:0.8rem;font-weight:500;transition:all 0.2s;
        }
        .tbl-btn-edit{background:#eff6ff;color:#2563eb;}
        .tbl-btn-edit:hover{background:#dbeafe;}
        .tbl-btn-del{background:#fef2f2;color:#dc2626;}
        .tbl-btn-del:hover{background:#fee2e2;}
        .tbl-btn-view{background:#f0fdf4;color:#16a34a;}
        .tbl-btn-view:hover{background:#dcfce7;}

        /* Action button in header */
        .btn-add{
            display:inline-flex;align-items:center;gap:6px;padding:8px 16px;
            background:#d70018;color:white;border-radius:8px;font-size:0.875rem;font-weight:600;
            transition:all 0.2s;
        }
        .btn-add:hover{background:#b80015;transform:translateY(-1px);box-shadow:0 4px 10px rgba(215,0,24,0.2);}

        /* Forms */
        .admin-form{padding:20px;}
        .admin-form label{display:block;font-size:0.875rem;font-weight:600;color:#374151;margin-bottom:6px;}
        .admin-form input,.admin-form textarea,.admin-form select{
            width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:0.9rem;font-family:inherit;
            background:white;color:#1e293b;transition:border-color 0.2s,box-shadow 0.2s;
        }
        .admin-form input:focus,.admin-form textarea:focus,.admin-form select:focus{
            outline:none;border-color:#d70018;box-shadow:0 0 0 3px rgba(215,0,24,0.08);
        }
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:16px;}
        .form-group{margin-bottom:16px;}
        .form-actions{display:flex;gap:12px;padding-top:4px;}
        .btn-submit{
            padding:9px 20px;background:#d70018;color:white;border:none;border-radius:8px;
            font-size:0.9rem;font-weight:600;cursor:pointer;transition:all 0.2s;
        }
        .btn-submit:hover{background:#b80015;}
        .btn-cancel-form{
            padding:9px 20px;background:#f1f5f9;color:#64748b;border:none;border-radius:8px;
            font-size:0.9rem;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;
        }
        .alert-danger{
            background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:12px 16px;
            border-radius:8px;margin-bottom:16px;font-size:0.9rem;
        }
    </style>
</head>
<body>
    <aside class="admin-sidebar">
        <div class="admin-logo">
            <div class="logo-icon">K</div>
            <div>
                <div class="logo-text">KhangStore</div>
                <div class="logo-sub">Admin Panel</div>
            </div>
        </div>
        <nav class="admin-nav">
            <div class="nav-section-label">Tổng quan</div>
            <a href="<?php echo BASE_URL; ?>/Admin/dashboard" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/Admin/dashboard') !== false || $_SERVER['REQUEST_URI'] === BASE_URL . '/Admin') ? 'active' : ''; ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                Dashboard
            </a>
            <div class="nav-section-label">Quản lý</div>
            <a href="<?php echo BASE_URL; ?>/Admin/products" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/Admin/products') !== false ? 'active' : ''; ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                Sản phẩm
            </a>
            <a href="<?php echo BASE_URL; ?>/Admin/categories" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/Admin/categories') !== false ? 'active' : ''; ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                Danh mục
            </a>
            <a href="<?php echo BASE_URL; ?>/Admin/users" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/Admin/users') !== false ? 'active' : ''; ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                Người dùng
            </a>
            <div class="nav-section-label">Khách hàng</div>
            <a href="<?php echo BASE_URL; ?>/Product/list" target="_blank">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                Xem Cửa hàng
            </a>
        </nav>
        <div class="admin-sidebar-footer">
            <div class="admin-avatar"><?php echo strtoupper(substr(SessionHelper::get('username'), 0, 1)); ?></div>
            <div class="admin-user-info">
                <div class="admin-user-name"><?php echo htmlspecialchars(SessionHelper::get('username')); ?></div>
                <div class="admin-user-role">Quản trị viên</div>
            </div>
            <a href="<?php echo BASE_URL; ?>/User/logout" title="Đăng xuất" style="color:#64748b;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
            </a>
        </div>
    </aside>

    <div class="admin-main">
        <div class="admin-topbar">
            <div class="topbar-title"><?php echo $pageTitle ?? 'Dashboard'; ?></div>
            <div class="topbar-actions">
                <a href="<?php echo BASE_URL; ?>/Product/list" target="_blank" class="topbar-actions btn-view-site">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    Xem Trang chủ
                </a>
                <a href="<?php echo BASE_URL; ?>/User/logout" class="topbar-actions btn-logout">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    Đăng xuất
                </a>
            </div>
        </div>
        <div class="admin-content">
            <?php echo $adminContent ?? ''; ?>
        </div>
    </div>
</body>
</html>

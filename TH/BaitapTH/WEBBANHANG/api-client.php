<?php
require_once 'app/config/database.php';
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$base_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($base_dir == '/') $base_dir = '';
$baseUrl = $protocol . '://' . $host . $base_dir;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KhangStore API Client</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #0d1117;
            --bg-2: #161b22;
            --bg-3: #1c2230;
            --border: rgba(255,255,255,0.08);
            --text: #e6edf3;
            --text-muted: #7d8590;
            --accent: #2f81f7;
            --accent-hover: #388bff;
            --success: #3fb950;
            --warning: #d29922;
            --danger: #f85149;
            --purple: #8b949e;
            --radius: 8px;
            --shadow: 0 8px 24px rgba(0,0,0,0.4);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            width: 300px;
            flex-shrink: 0;
            background: var(--bg-2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .sidebar-header {
            padding: 20px 20px 16px;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-brand {
            display: flex; align-items: center; gap: 10px; margin-bottom: 4px;
        }
        .brand-icon {
            width: 32px; height: 32px; background: linear-gradient(135deg, #d70018, #ff4757);
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 14px; color: white;
        }
        .brand-name { font-size: 1rem; font-weight: 700; color: var(--text); }
        .brand-sub { font-size: 0.75rem; color: var(--text-muted); margin-top: 2px; }

        /* Auth Section */
        .auth-section {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            background: rgba(47, 129, 247, 0.05);
        }
        .auth-section h4 {
            font-size: 0.7rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: 1px; color: var(--text-muted); margin-bottom: 10px;
        }
        .auth-status {
            display: flex; align-items: center; gap: 8px; margin-bottom: 10px;
        }
        .status-dot {
            width: 8px; height: 8px; border-radius: 50%; background: var(--danger); flex-shrink: 0;
            transition: all 0.3s;
        }
        .status-dot.active { background: var(--success); box-shadow: 0 0 6px var(--success); }
        .auth-label { font-size: 0.8rem; color: var(--text-muted); }
        .auth-credentials { display: flex; gap: 8px; }
        .auth-input {
            flex: 1; background: var(--bg); border: 1px solid var(--border); border-radius: var(--radius);
            padding: 7px 10px; color: var(--text); font-size: 0.8rem; font-family: inherit; outline: none;
            transition: border-color 0.2s;
        }
        .auth-input:focus { border-color: var(--accent); }
        .btn-login {
            padding: 7px 14px; background: var(--accent); color: white; border: none;
            border-radius: var(--radius); font-size: 0.8rem; font-weight: 600; cursor: pointer;
            transition: all 0.2s; white-space: nowrap;
        }
        .btn-login:hover { background: var(--accent-hover); }

        /* Endpoint List */
        .endpoint-list { flex: 1; overflow-y: auto; padding: 12px; }
        .endpoint-group { margin-bottom: 8px; }
        .group-label {
            font-size: 0.7rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: 1px; color: var(--text-muted); padding: 4px 8px; margin-bottom: 4px;
        }
        .endpoint-item {
            display: flex; align-items: center; gap: 10px; padding: 10px 12px;
            border-radius: var(--radius); cursor: pointer; transition: all 0.15s;
            border: 1px solid transparent;
        }
        .endpoint-item:hover { background: rgba(255,255,255,0.04); border-color: var(--border); }
        .endpoint-item.active { background: rgba(47,129,247,0.12); border-color: rgba(47,129,247,0.3); }

        .method-badge {
            font-size: 0.65rem; font-weight: 700; padding: 2px 7px; border-radius: 4px;
            font-family: 'JetBrains Mono', monospace; letter-spacing: 0.5px; flex-shrink: 0; width: 46px;
            text-align: center;
        }
        .method-GET    { background: rgba(63,185,80,0.15);  color: var(--success); }
        .method-POST   { background: rgba(47,129,247,0.15); color: var(--accent);  }
        .method-PUT    { background: rgba(210,153,34,0.15); color: var(--warning); }
        .method-DELETE { background: rgba(248,81,73,0.15);  color: var(--danger);  }

        .endpoint-name { font-size: 0.82rem; color: var(--text); font-weight: 500; }
        .endpoint-path { font-size: 0.72rem; color: var(--text-muted); font-family: 'JetBrains Mono', monospace; }

        /* ========== MAIN AREA ========== */
        .main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }

        .request-panel {
            background: var(--bg-2);
            border-bottom: 1px solid var(--border);
            padding: 20px 24px;
        }
        .request-title {
            font-size: 1.1rem; font-weight: 700; color: var(--text); margin-bottom: 4px;
        }
        .request-desc {
            font-size: 0.82rem; color: var(--text-muted); margin-bottom: 16px;
        }

        .request-url-bar {
            display: flex; gap: 10px; align-items: center;
        }
        .method-select {
            background: var(--bg-3); border: 1px solid var(--border); border-radius: var(--radius);
            color: var(--text); font-size: 0.85rem; font-weight: 700; font-family: 'JetBrains Mono', monospace;
            padding: 10px 14px; cursor: pointer; outline: none; min-width: 90px;
        }
        .url-input {
            flex: 1; background: var(--bg-3); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 10px 14px; color: var(--text);
            font-size: 0.875rem; font-family: 'JetBrains Mono', monospace; outline: none;
            transition: border-color 0.2s;
        }
        .url-input:focus { border-color: var(--accent); }
        .btn-send {
            padding: 10px 20px; background: var(--accent); color: white; border: none;
            border-radius: var(--radius); font-size: 0.9rem; font-weight: 600; cursor: pointer;
            transition: all 0.2s; display: flex; align-items: center; gap: 8px;
        }
        .btn-send:hover { background: var(--accent-hover); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(47,129,247,0.3); }
        .btn-send.loading { opacity: 0.7; cursor: not-allowed; transform: none; }

        /* Tabs */
        .tabs { display: flex; gap: 0; padding: 0 24px; border-bottom: 1px solid var(--border); }
        .tab-btn {
            padding: 12px 16px; font-size: 0.85rem; font-weight: 500; cursor: pointer;
            color: var(--text-muted); background: none; border: none; border-bottom: 2px solid transparent;
            transition: all 0.15s; margin-bottom: -1px;
        }
        .tab-btn.active { color: var(--accent); border-bottom-color: var(--accent); }
        .tab-btn:hover:not(.active) { color: var(--text); }

        .tab-content { display: none; flex: 1; overflow: auto; padding: 20px 24px; }
        .tab-content.active { display: block; }

        /* Body Editor */
        .body-editor {
            background: var(--bg-3); border: 1px solid var(--border); border-radius: var(--radius);
            padding: 16px; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem;
            color: #a8d8a8; line-height: 1.6; resize: vertical; min-height: 160px;
            width: 100%; outline: none; transition: border-color 0.2s;
        }
        .body-editor:focus { border-color: var(--accent); }

        /* Response area */
        .response-area { flex: 1; display: flex; flex-direction: column; overflow: hidden; background: var(--bg); }

        .response-meta {
            display: flex; align-items: center; gap: 16px; padding: 16px 24px;
            border-bottom: 1px solid var(--border); font-size: 0.82rem;
        }
        .status-badge {
            padding: 4px 10px; border-radius: var(--radius); font-weight: 700;
            font-family: 'JetBrains Mono', monospace; font-size: 0.8rem;
        }
        .status-2xx { background: rgba(63,185,80,0.15); color: var(--success); }
        .status-4xx { background: rgba(248,81,73,0.15); color: var(--danger); }
        .status-5xx { background: rgba(248,81,73,0.15); color: var(--danger); }
        .response-time { color: var(--text-muted); }

        .response-body-wrapper { flex: 1; overflow: auto; padding: 20px 24px; }
        .response-body {
            background: var(--bg-3); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 20px;
            font-family: 'JetBrains Mono', monospace; font-size: 0.83rem;
            line-height: 1.7; white-space: pre-wrap; word-break: break-all;
            min-height: 200px; color: #a8d8a8;
        }
        .response-placeholder {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            height: 100%; color: var(--text-muted); gap: 16px; text-align: center;
        }
        .response-placeholder svg { opacity: 0.3; }
        .response-placeholder h3 { font-size: 1rem; font-weight: 600; color: var(--text-muted); }
        .response-placeholder p { font-size: 0.85rem; }

        /* JSON Syntax Highlighting */
        .json-key     { color: #79b8ff; }
        .json-string  { color: #9ecbff; }
        .json-number  { color: #f8c555; }
        .json-boolean { color: #ff7b72; }
        .json-null    { color: #ff7b72; }

        /* Scrollbar styling */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }

        /* Toast */
        .toast {
            position: fixed; top: 20px; right: 20px; padding: 12px 18px;
            border-radius: var(--radius); font-size: 0.85rem; font-weight: 500; z-index: 9999;
            animation: slideIn 0.3s ease; pointer-events: none;
        }
        .toast-success { background: rgba(63,185,80,0.9); color: white; }
        .toast-error   { background: rgba(248,81,73,0.9); color: white; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        .field-label { font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; display: block; }
        .form-group { margin-bottom: 14px; }
    </style>
</head>
<body>

<!-- ========== SIDEBAR ========== -->
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <div class="brand-icon">K</div>
            <div>
                <div class="brand-name">KhangStore</div>
                <div class="brand-sub">API Client v1.0</div>
            </div>
        </div>
    </div>

    <!-- AUTH SECTION -->
    <div class="auth-section">
        <h4>Xác thực JWT</h4>
        <div class="auth-status">
            <div class="status-dot" id="authDot"></div>
            <span class="auth-label" id="authLabel">Chưa đăng nhập</span>
        </div>
        <div class="auth-credentials">
            <input type="text" class="auth-input" id="loginUser" placeholder="Username" value="admin">
            <input type="password" class="auth-input" id="loginPass" placeholder="Password" value="admin123">
            <button class="btn-login" onclick="doLogin()">Login</button>
        </div>
    </div>

    <!-- ENDPOINT LIST -->
    <div class="endpoint-list">
        <div class="endpoint-group">
            <div class="group-label">🔑 Xác thực</div>
            <div class="endpoint-item active" onclick="selectEndpoint(this)" 
                data-method="POST" data-url="<?= $baseUrl ?>/api/user/login"
                data-name="Đăng nhập" data-desc="Đăng nhập và lấy JWT Token"
                data-body='{"username": "admin", "password": "admin123"}'
                data-requires-auth="false">
                <span class="method-badge method-POST">POST</span>
                <div>
                    <div class="endpoint-name">Đăng nhập</div>
                    <div class="endpoint-path">/api/user/login</div>
                </div>
            </div>
        </div>

        <div class="endpoint-group">
            <div class="group-label">📦 Sản phẩm</div>
            <div class="endpoint-item" onclick="selectEndpoint(this)"
                data-method="GET" data-url="<?= $baseUrl ?>/api/product"
                data-name="Danh sách sản phẩm" data-desc="Lấy toàn bộ danh sách sản phẩm"
                data-body="" data-requires-auth="true">
                <span class="method-badge method-GET">GET</span>
                <div>
                    <div class="endpoint-name">Danh sách sản phẩm</div>
                    <div class="endpoint-path">/api/product</div>
                </div>
            </div>
            <div class="endpoint-item" onclick="selectEndpoint(this)"
                data-method="GET" data-url="<?= $baseUrl ?>/api/product/1"
                data-name="Chi tiết sản phẩm" data-desc="Lấy thông tin 1 sản phẩm theo ID"
                data-body="" data-requires-auth="true">
                <span class="method-badge method-GET">GET</span>
                <div>
                    <div class="endpoint-name">Chi tiết sản phẩm</div>
                    <div class="endpoint-path">/api/product/{id}</div>
                </div>
            </div>
            <div class="endpoint-item" onclick="selectEndpoint(this)"
                data-method="POST" data-url="<?= $baseUrl ?>/api/product"
                data-name="Thêm sản phẩm" data-desc="Tạo sản phẩm mới (yêu cầu token admin)"
                data-body='{"name": "iPhone 16 Pro","description": "Điện thoại Apple mới nhất","price": 34990000,"category_id": 1,"image": "https://images.unsplash.com/photo-1695048133142-1a20484d2569"}'
                data-requires-auth="true">
                <span class="method-badge method-POST">POST</span>
                <div>
                    <div class="endpoint-name">Thêm sản phẩm</div>
                    <div class="endpoint-path">/api/product</div>
                </div>
            </div>
            <div class="endpoint-item" onclick="selectEndpoint(this)"
                data-method="PUT" data-url="<?= $baseUrl ?>/api/product/1"
                data-name="Cập nhật sản phẩm" data-desc="Cập nhật thông tin sản phẩm theo ID"
                data-body='{"name": "iPhone 15 Pro (Updated)","description": "Mô tả đã cập nhật","price": 28000000,"category_id": 1,"image": ""}'
                data-requires-auth="true">
                <span class="method-badge method-PUT">PUT</span>
                <div>
                    <div class="endpoint-name">Cập nhật sản phẩm</div>
                    <div class="endpoint-path">/api/product/{id}</div>
                </div>
            </div>
            <div class="endpoint-item" onclick="selectEndpoint(this)"
                data-method="DELETE" data-url="<?= $baseUrl ?>/api/product/1"
                data-name="Xóa sản phẩm" data-desc="Xóa sản phẩm theo ID"
                data-body="" data-requires-auth="true">
                <span class="method-badge method-DELETE">DEL</span>
                <div>
                    <div class="endpoint-name">Xóa sản phẩm</div>
                    <div class="endpoint-path">/api/product/{id}</div>
                </div>
            </div>
        </div>

        <div class="endpoint-group">
            <div class="group-label">🗂️ Danh mục</div>
            <div class="endpoint-item" onclick="selectEndpoint(this)"
                data-method="GET" data-url="<?= $baseUrl ?>/api/category"
                data-name="Danh sách danh mục" data-desc="Lấy toàn bộ danh mục sản phẩm"
                data-body="" data-requires-auth="true">
                <span class="method-badge method-GET">GET</span>
                <div>
                    <div class="endpoint-name">Danh sách danh mục</div>
                    <div class="endpoint-path">/api/category</div>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- ========== MAIN AREA ========== -->
<div class="main">
    <!-- Request Panel -->
    <div class="request-panel">
        <div class="request-title" id="reqTitle">Đăng nhập</div>
        <div class="request-desc" id="reqDesc">Đăng nhập và lấy JWT Token</div>
        <div class="request-url-bar">
            <select class="method-select" id="methodSelect">
                <option value="GET">GET</option>
                <option value="POST" selected>POST</option>
                <option value="PUT">PUT</option>
                <option value="DELETE">DELETE</option>
            </select>
            <input type="text" class="url-input" id="urlInput" value="<?= $baseUrl ?>/api/user/login">
            <button class="btn-send" id="btnSend" onclick="sendRequest()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Gửi
            </button>
        </div>
    </div>

    <!-- Tabs: Headers / Body -->
    <div class="tabs">
        <button class="tab-btn active" onclick="switchTab('body', this)">Body (JSON)</button>
        <button class="tab-btn" onclick="switchTab('headers', this)">Headers</button>
        <button class="tab-btn" onclick="switchTab('info', this)">Thông tin</button>
    </div>

    <div class="tab-content active" id="tab-body">
        <div class="form-group">
            <label class="field-label">Request Body (JSON)</label>
            <textarea class="body-editor" id="bodyEditor" rows="8" placeholder="Nhập JSON body tại đây...">{&#13;  "username": "admin",&#13;  "password": "admin123"&#13;}</textarea>
        </div>
    </div>
    <div class="tab-content" id="tab-headers" style="display:none;">
        <div class="form-group">
            <label class="field-label">Authorization Token (Tự động điền sau khi login)</label>
            <textarea class="body-editor" id="tokenDisplay" rows="4" placeholder="Token sẽ xuất hiện ở đây sau khi bạn đăng nhập..." readonly style="color: #f8c555; resize: none;"></textarea>
        </div>
        <div class="form-group">
            <label class="field-label">Content-Type</label>
            <input type="text" class="body-editor" style="height: auto; padding: 10px 14px;" value="application/json" readonly>
        </div>
    </div>
    <div class="tab-content" id="tab-info" style="display:none;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; max-width: 800px;">
            <div style="background: var(--bg-3); border: 1px solid var(--border); border-radius: var(--radius); padding: 16px;">
                <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 8px; font-weight: 600;">Base URL</div>
                <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; color: var(--accent);"><?= $baseUrl ?></div>
            </div>
            <div style="background: var(--bg-3); border: 1px solid var(--border); border-radius: var(--radius); padding: 16px;">
                <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 8px; font-weight: 600;">Auth Type</div>
                <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; color: var(--warning);">Bearer JWT Token</div>
            </div>
            <div style="background: var(--bg-3); border: 1px solid var(--border); border-radius: var(--radius); padding: 16px; grid-column: 1 / -1;">
                <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 12px; font-weight: 600;">Danh sách Endpoints</div>
                <table style="width:100%; border-collapse: collapse; font-size: 0.82rem;">
                    <thead><tr style="border-bottom: 1px solid var(--border);">
                        <th style="text-align:left; padding: 8px; color: var(--text-muted);">Method</th>
                        <th style="text-align:left; padding: 8px; color: var(--text-muted);">Endpoint</th>
                        <th style="text-align:left; padding: 8px; color: var(--text-muted);">Mô tả</th>
                        <th style="text-align:left; padding: 8px; color: var(--text-muted);">Auth</th>
                    </tr></thead>
                    <tbody>
                        <?php
                        $endpoints = [
                            ['POST', '/api/user/login', 'Đăng nhập, lấy JWT Token', 'Không'],
                            ['GET', '/api/product', 'Danh sách tất cả sản phẩm', 'Cần'],
                            ['GET', '/api/product/{id}', 'Chi tiết một sản phẩm', 'Cần'],
                            ['POST', '/api/product', 'Thêm sản phẩm mới', 'Cần'],
                            ['PUT', '/api/product/{id}', 'Cập nhật sản phẩm', 'Cần'],
                            ['DELETE', '/api/product/{id}', 'Xóa sản phẩm', 'Cần'],
                            ['GET', '/api/category', 'Danh sách danh mục', 'Cần'],
                        ];
                        $methodColors = ['GET' => '#3fb950', 'POST' => '#2f81f7', 'PUT' => '#d29922', 'DELETE' => '#f85149'];
                        foreach ($endpoints as $ep):
                        ?>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
                            <td style="padding: 8px;">
                                <span style="background: rgba(<?= $ep[0]=='GET'?'63,185,80':($ep[0]=='POST'?'47,129,247':($ep[0]=='PUT'?'210,153,34':'248,81,73')) ?>,0.15); color: <?= $methodColors[$ep[0]] ?>; padding: 2px 8px; border-radius: 4px; font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; font-weight: 700;"><?= $ep[0] ?></span>
                            </td>
                            <td style="padding: 8px; font-family: 'JetBrains Mono', monospace; color: #79b8ff;"><?= $ep[1] ?></td>
                            <td style="padding: 8px; color: var(--text-muted);"><?= $ep[2] ?></td>
                            <td style="padding: 8px; color: <?= $ep[3]=='Cần' ? '#f8c555' : 'var(--text-muted)' ?>;"><?= $ep[3] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Response Area -->
    <div class="response-area">
        <div class="response-meta" id="responseMeta" style="display: none;">
            <span class="status-badge" id="statusBadge"></span>
            <span class="response-time" id="responseTime"></span>
            <span class="response-time" id="responseSize"></span>
            <button onclick="copyResponse()" style="margin-left: auto; background: var(--bg-3); border: 1px solid var(--border); color: var(--text-muted); padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; cursor: pointer;">Copy</button>
        </div>
        <div class="response-body-wrapper" id="responseBodyWrapper">
            <div class="response-placeholder" id="responsePlaceholder">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 2L11 13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                <h3>Bấm "Gửi" để thực hiện request</h3>
                <p>Kết quả phản hồi từ API sẽ hiển thị ở đây</p>
            </div>
            <pre class="response-body" id="responseBody" style="display: none;"></pre>
        </div>
    </div>
</div>

<script>
    let jwtToken = localStorage.getItem('khangstoreToken') || '';
    const BASE_URL = '<?= $baseUrl ?>';

    // Restore token on load
    window.addEventListener('DOMContentLoaded', () => {
        if (jwtToken) {
            updateAuthStatus(true);
            document.getElementById('tokenDisplay').value = jwtToken;
        }
        selectEndpoint(document.querySelector('.endpoint-item.active'));
    });

    function updateAuthStatus(loggedIn) {
        const dot = document.getElementById('authDot');
        const label = document.getElementById('authLabel');
        if (loggedIn) {
            dot.classList.add('active');
            label.textContent = 'Đã đăng nhập ✓';
        } else {
            dot.classList.remove('active');
            label.textContent = 'Chưa đăng nhập';
        }
    }

    async function doLogin() {
        const username = document.getElementById('loginUser').value;
        const password = document.getElementById('loginPass').value;
        try {
            const res = await fetch(`${BASE_URL}/api/user/login`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ username, password })
            });
            const data = await res.json();
            if (res.ok && data.token) {
                jwtToken = data.token;
                localStorage.setItem('khangstoreToken', jwtToken);
                document.getElementById('tokenDisplay').value = jwtToken;
                updateAuthStatus(true);
                showToast('Đăng nhập thành công! Token đã được lưu.', 'success');
            } else {
                showToast(data.message || 'Đăng nhập thất bại', 'error');
            }
        } catch (e) {
            showToast('Lỗi kết nối máy chủ', 'error');
        }
    }

    function selectEndpoint(el) {
        document.querySelectorAll('.endpoint-item').forEach(i => i.classList.remove('active'));
        el.classList.add('active');

        const method = el.dataset.method;
        const url    = el.dataset.url;
        const name   = el.dataset.name;
        const desc   = el.dataset.desc;
        const body   = el.dataset.body;

        document.getElementById('methodSelect').value   = method;
        document.getElementById('urlInput').value       = url;
        document.getElementById('reqTitle').textContent = name;
        document.getElementById('reqDesc').textContent  = desc;

        try {
            const parsed = body ? JSON.parse(body) : null;
            document.getElementById('bodyEditor').value = parsed ? JSON.stringify(parsed, null, 2) : '';
        } catch(e) {
            document.getElementById('bodyEditor').value = body || '';
        }

        // Reset response
        document.getElementById('responsePlaceholder').style.display   = 'flex';
        document.getElementById('responseBody').style.display          = 'none';
        document.getElementById('responseMeta').style.display          = 'none';
    }

    function switchTab(tab, btn) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => { c.style.display = 'none'; c.classList.remove('active'); });
        btn.classList.add('active');
        const el = document.getElementById('tab-' + tab);
        el.style.display = 'block'; el.classList.add('active');
    }

    async function sendRequest() {
        const method = document.getElementById('methodSelect').value;
        const url    = document.getElementById('urlInput').value;
        const body   = document.getElementById('bodyEditor').value.trim();

        const btn = document.getElementById('btnSend');
        btn.classList.add('loading');
        btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 0.8s linear infinite;"><path d="M21 12a9 9 0 11-6.219-8.56"/></svg> Đang gửi...`;

        const startTime = Date.now();

        const headers = { 'Content-Type': 'application/json' };
        if (jwtToken) headers['Authorization'] = `Bearer ${jwtToken}`;

        const options = { method, headers };
        if (['POST', 'PUT', 'PATCH'].includes(method) && body) {
            options.body = body;
        }

        try {
            const res = await fetch(url, options);
            const elapsed = Date.now() - startTime;
            const text = await res.text();
            let json;
            try { json = JSON.parse(text); } catch(e) { json = null; }

            // If it's a login response and has token, auto-save
            if (json && json.token) {
                jwtToken = json.token;
                localStorage.setItem('khangstoreToken', jwtToken);
                document.getElementById('tokenDisplay').value = jwtToken;
                updateAuthStatus(true);
            }

            displayResponse(res.status, elapsed, text, json);
        } catch(err) {
            displayError(err.message);
        } finally {
            btn.classList.remove('loading');
            btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg> Gửi`;
        }
    }

    function displayResponse(status, elapsed, text, json) {
        const meta     = document.getElementById('responseMeta');
        const badge    = document.getElementById('statusBadge');
        const timeEl   = document.getElementById('responseTime');
        const sizeEl   = document.getElementById('responseSize');
        const body     = document.getElementById('responseBody');
        const placeholder = document.getElementById('responsePlaceholder');

        meta.style.display = 'flex';
        placeholder.style.display = 'none';
        body.style.display = 'block';

        // Status badge
        badge.textContent = `${status} ${getStatusText(status)}`;
        badge.className = 'status-badge';
        if (status >= 200 && status < 300) badge.classList.add('status-2xx');
        else if (status >= 400 && status < 500) badge.classList.add('status-4xx');
        else badge.classList.add('status-5xx');

        timeEl.textContent = `${elapsed}ms`;
        sizeEl.textContent = `${text.length} bytes`;

        // Format & syntax highlight JSON
        let displayText = text;
        if (json !== null) {
            displayText = JSON.stringify(json, null, 2);
            body.innerHTML = syntaxHighlight(displayText);
        } else {
            body.textContent = displayText;
        }
    }

    function displayError(msg) {
        const meta = document.getElementById('responseMeta');
        const badge = document.getElementById('statusBadge');
        const body = document.getElementById('responseBody');
        const placeholder = document.getElementById('responsePlaceholder');

        meta.style.display = 'flex';
        placeholder.style.display = 'none';
        body.style.display = 'block';

        badge.textContent = 'Network Error';
        badge.className = 'status-badge status-4xx';
        body.textContent = `Lỗi: ${msg}`;
    }

    function syntaxHighlight(json) {
        return json
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function(match) {
                let cls = 'json-number';
                if (/^"/.test(match)) cls = /:$/.test(match) ? 'json-key' : 'json-string';
                else if (/true|false/.test(match)) cls = 'json-boolean';
                else if (/null/.test(match)) cls = 'json-null';
                return `<span class="${cls}">${match}</span>`;
            });
    }

    function getStatusText(status) {
        const texts = { 200: 'OK', 201: 'Created', 204: 'No Content', 400: 'Bad Request', 401: 'Unauthorized', 403: 'Forbidden', 404: 'Not Found', 500: 'Server Error' };
        return texts[status] || '';
    }

    function copyResponse() {
        const text = document.getElementById('responseBody').textContent;
        navigator.clipboard.writeText(text).then(() => showToast('Đã sao chép phản hồi!', 'success'));
    }

    function showToast(msg, type) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.textContent = msg;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // Enter to send
    document.addEventListener('keydown', e => {
        if (e.ctrlKey && e.key === 'Enter') sendRequest();
    });

    const style = document.createElement('style');
    style.textContent = `@keyframes spin { to { transform: rotate(360deg); } }`;
    document.head.appendChild(style);
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sinh viên</title>
    <style>
        * { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }
        body { 
            font-family: sans-serif; 
            background: #f5f5f5; 
            color: #1a1a1a; }

        .container {
            padding: 2rem;
        }

        h1 { 
            font-size: 22px; 
            font-weight: 500; 
            margin-bottom: 1.5rem; }

        .table-wrap {
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            overflow: hidden;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 14px; }

        thead tr { 
            background: #f9f9f9; 
        }
        thead th {
            padding: 12px 16px;
            text-align: left;
            font-weight: 500;
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e5e5e5;
        }

        tbody tr { 
            border-bottom: 1px solid #f0f0f0; 
            transition: background 0.15s; 
        }
        tbody tr:last-child { 
            border-bottom: none; 
        }
        tbody tr:hover { 
            background: #f9f9f9; 
        }
        tbody td { 
            padding: 12px 16px; 
        }

        .id-cell { 
            color: #999; 
            font-family: monospace; 
        }
        .name-cell { 
            font-weight: 500; 
        }
        .mssv-cell { 
            font-family: monospace; 
            color: #555; 
        }

        .gender-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 500;
        }
        .male   { background: #E6F1FB; color: #0C447C; }
        .female { background: #FBEAF0; color: #72243E; }
    .bottom-actions {
            display: flex;
            justify-content: space-between; 
            align-items: center;
            margin-top: 16px;
        }

        .add-button a {
            display: inline-block;
            background-color: #0C447C; 
            color: #fff;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.2s;
        }

        .add-button a:hover {
            background-color: #083058;
        }

        .pagination {
            display: flex;
            gap: 6px;
        }

        .pagination a, .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 10px;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
            color: #555;
            background: #fff;
            border: 1px solid #e5e5e5;
            transition: all 0.2s;
        }

        .pagination a:hover {
            border-color: #0C447C;
            color: #0C447C;
        }

        .pagination .active {
            background: #0C447C;
            color: #fff;
            border-color: #0C447C;
            font-weight: bold;
            pointer-events: none;
        }

        .pagination .disabled {
            color: #bbb;
            background: #fafafa;
            pointer-events: none;
        }

        .action-cell a {
            margin-right: 8px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            text-decoration: none;
            color: #fff;
        }

        .btn-edit, .btn-delete {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.2s;
        }

        .btn-edit {
            background-color: #4CAF50; 
        }

        .btn-edit:hover {
            background-color: #3e8e41;
        }

        .btn-delete {
            background-color: #f44336; 
        }

        .btn-delete:hover {
            background-color: #da190b;
        }

        .search-bar {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }
        .search-bar input, .search-bar select {
            padding: 8px 12px;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            background: #fff;
        }
        .search-bar input:focus, .search-bar select:focus {
            border-color: #0C447C;
        }
        .search-bar button {
            padding: 8px 16px;
            background: #0C447C;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
        }
        .search-bar button:hover { background: #083058; }
        .search-bar .btn-reset {
            background: #f5f5f5;
            color: #555;
            border: 1px solid #e5e5e5;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
        }
        .sort-link { color: #888; text-decoration: none; font-size: 11px; }
        .sort-link.active { color: #0C447C; font-weight: bold; }

    </style>
</head>
<body>
    <div class="container">
        <h1>Danh sách sinh viên</h1>
        <form class="search-bar" method="GET" action="/sinhvien/index">
            <input type="text" name="keyword" placeholder="Tìm theo họ tên..."
                value="<?= htmlspecialchars($keyword ?? '') ?>">

            <select name="sortBy">
                <option value="hoten"  <?= ($sortBy ?? '') === 'hoten'  ? 'selected' : '' ?>>Sắp xếp: Họ tên</option>
                <option value="mssv"   <?= ($sortBy ?? '') === 'mssv'   ? 'selected' : '' ?>>Sắp xếp: MSSV</option>
                <option value="malop"  <?= ($sortBy ?? '') === 'malop'  ? 'selected' : '' ?>>Sắp xếp: Lớp</option>
                <option value="mssv_asc"  <?= ($sortBy ?? '') === 'mssv_asc'  ? 'selected' : '' ?>>Sắp xếp: MSSV (nhỏ → lớn)</option>
                <option value="mssv_desc" <?= ($sortBy ?? '') === 'mssv_desc' ? 'selected' : '' ?>>Sắp xếp: MSSV (lớn → nhỏ)</option>
            </select>

            <select name="sortOrder">
                <option value="ASC"  <?= ($sortOrder ?? '') === 'ASC'  ? 'selected' : '' ?>>A → Z</option>
                <option value="DESC" <?= ($sortOrder ?? '') === 'DESC' ? 'selected' : '' ?>>Z → A</option>
            </select>

            <button type="submit">Tìm kiếm</button>
            <a href="/sinhvien/index" class="btn-reset">Xóa lọc</a>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>MSSV</th>
                        <th>Lớp</th> 
                        <th>Giới tính</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <?php $stt = ($offset ?? 0) + 1; ?>
                <tbody>
                    <?php foreach (($sinhviens ?? []) as $sinhvien): ?>
                    <tr>
                        <td class="id-cell"><?= str_pad($stt++, 2, '0', STR_PAD_LEFT) ?></td>
                        <td class="name-cell"><?= $sinhvien['hoten'] ?></td>
                        <td class="mssv-cell"><?= $sinhvien['mssv'] ?></td>
                        <td><?= $sinhvien['tenlop'] ?? '<span style="color:#bbb">Chưa có</span>' ?></td> 
                        <td>
                            <span class="gender-badge <?= $sinhvien['gioitinh'] === 'Nam' ? 'male' : 'female' ?>">
                                <?= $sinhvien['gioitinh'] ?>
                            </span>
                        </td>
                        </td>
                        <td class="action-cell">
                            <?php
                            $queryString = http_build_query([
                                'page'      => $currentPage ?? 1,
                                'keyword'   => $keyword   ?? '',
                                'malop'     => $malop     ?? '',
                                'sortBy'    => $sortBy    ?? 'hoten',
                                'sortOrder' => $sortOrder ?? 'ASC',
                            ]);
                            ?>
                            <a href="/sinhvien/edit/<?= $sinhvien['id'] ?>?<?= $queryString ?>" class="btn-edit">Sửa</a>
                            <a href="/sinhvien/delete/<?= $sinhvien['id'] ?>?<?= $queryString ?>" class="btn-delete"
                            onclick="return confirm('Xóa sinh viên này?')">Xóa</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="bottom-actions">
            <div class="add-button">
                <a href="/sinhvien/create">+ Thêm sinh viên</a>
            </div>
            <div class="pagination">
                <?php 
                    $current   = $currentPage ?? 1;
                    $total     = $totalPages  ?? 1;
                    $params    = http_build_query([
                        'keyword'   => $keyword   ?? '',
                        'malop'     => $malop     ?? '',
                        'sortBy'    => $sortBy    ?? 'hoten',
                        'sortOrder' => $sortOrder ?? 'ASC',
                    ]);
                    $url = "?$params&page=";
                ?>
                <?php if ($current > 1): ?>
                    <a href="<?= $url . ($current - 1) ?>">&laquo; Trước</a>
                <?php else: ?>
                    <span class="disabled">&laquo; Trước</span>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total; $i++): ?>
                    <?php if ($i == $current): ?>
                        <span class="active"><?= $i ?></span>
                    <?php else: ?>
                        <a href="<?= $url . $i ?>"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($current < $total): ?>
                    <a href="<?= $url . ($current + 1) ?>">Tiếp &raquo;</a>
                <?php else: ?>
                    <span class="disabled">Tiếp &raquo;</span>
                <?php endif; ?>
            </div>
        </div>      
    </div>   
</body>
</html>
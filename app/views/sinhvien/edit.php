<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sửa sinh viên</title>
</head>
<body>
    <h1>Sửa thông tin sinh viên</h1>
    <?php $sinhvien = $sinhvien ?? []; ?>
    <form action="/sinhvien/update/<?php echo $sinhvien['id'] ?? ''; ?>" method="POST">
        
        <label for="hoten">Họ tên</label>
        <input type="text" name="hoten" id="hoten" value="<?php echo $sinhvien['hoten'] ?? ''; ?>"/><br><br>
        <label for="gioitinh">Giới tính</label>
        <select id="gioitinh" name="gioitinh" required>
            <option value="Nam" <?php echo (($sinhvien['gioitinh'] ?? '') == 'Nam') ? 'selected' : ''; ?>>Nam</option>
            <option value="Nữ" <?php echo (($sinhvien['gioitinh'] ?? '') == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
        </select><br><br>
        <label for="mssv">MSSV</label>
        <input type="text" name="mssv" id="mssv" value="<?php echo $sinhvien['mssv'] ?? ''; ?>"/><br><br>

        <input type="submit" value="Cập nhật thông tin">
    </form>
</body>
</html>
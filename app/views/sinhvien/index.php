<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
    <style>
table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #ddd;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2;}

tr:hover {background-color: #ddd;}

th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<body>
    <h1>Danh sách sinh viên</h1>
    <table>
        <tr>
            <th>STT</th>
            <th>Tên</th>
            <th>Giới tính</th>
            <th>MSSV</th>
            <th>Thao tác</th>
        </tr>
        <?php foreach(($sinhviens ?? []) as $index => $sinhvien): ?>
        <tr>
            <td><?php echo $index + 1; ?></td>
            <td style="display: none;"><?php echo $sinhvien['id']; ?></td>
            <td><?php echo $sinhvien['hoten']; ?></td>
            <td><?php echo $sinhvien['gioitinh']; ?></td>
            <td><?php echo $sinhvien['mssv']; ?></td>
            <td>
                <a class ="btn btn-primary" href="/sinhvien/edit/<?php echo $sinhvien['id']; ?>">Sửa</a>
                <a class ="btn btn-danger" href="/sinhvien/delete/<?php echo $sinhvien['id']; ?>">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div style ="margin-top: 20px;">
        <?php
            $pageSize = 5;
            $totalPage = $totalPage ?? 1;
    
            for($i = 1; $i <= $totalPage; $i++){
                $offset = ($i - 1) * $pageSize;
           echo "<a href='/sinhvien/index/$pageSize/$offset'>$i</a>";
        }
        ?>
    </div>
</body>
</html>
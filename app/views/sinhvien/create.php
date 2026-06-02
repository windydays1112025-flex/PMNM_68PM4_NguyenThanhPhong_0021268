<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=deivce-width, initial-scale=1.0">
    <title>Thêm sinh viên</title>
</head>
<body>
    <h1>Thêm sinh viên</h1>
    <form action="/sinhvien/store" method="post">
        <label for="hoten">Họ tên</label>
        <input type="text" name="hoten" id="hoten"/>
        <label for="gioitinh">Giới tính</label>
        <select id="gioitinh" name="gioitinh" required>
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select><br><br>
        <label for="mssv">MSSV</label>
        <input type="text" name="mssv" id="mssv"/>
        <input type="submit" value="Thêm sinh viên"/>
    </form>
</body>
</html>
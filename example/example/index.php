<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">PHP Example</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        <a class="nav-link" href="connect.php">Connect MySQL</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container my-3">
        <nav class="alert alert-primary" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Index</li>
            </ol>
        </nav>

        <?php
        session_start();

        // Kiểm tra xem đã kết nối cơ sở dữ liệu chưa
        if (isset($_SESSION['server']) && isset($_SESSION['database']) && isset($_SESSION['username']) && isset($_SESSION['password'])) {
            $server = $_SESSION['server'];
            $database = $_SESSION['database'];
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];

            // Tạo kết nối
            $conn = new mysqli($server, $username, $password, $database);

            // Kiểm tra kết nối
            if ($conn->connect_error) {
                die('<div class="alert alert-danger" role="alert">Kết nối thất bại: ' . $conn->connect_error . '</div>');
            }

            // Truy vấn danh sách khóa học
            $sql = "SELECT Id, Title, Description, ImageUrl FROM Course"; // Thêm ImageUrl vào truy vấn
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<table class="table table-bordered table-hover mt-3">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td><img src="' . htmlspecialchars($row['ImageUrl']) . '" alt="' . htmlspecialchars($row['Title']) . '" style="width: 100px;"></td>
                            <td>' . htmlspecialchars($row['Title']) . '</td>
                            <td>' . htmlspecialchars($row['Description']) . '</td>
                          </tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<div class="alert alert-warning" role="alert">Không có khóa học nào được tìm thấy.</div>';
            }

            // Đóng kết nối
            $conn->close();
        } else {
            echo '<div class="alert alert-danger" role="alert">Chưa kết nối đến cơ sở dữ liệu. Vui lòng kết nối tại trang <a href="connect.php">Connect MySQL</a>.</div>';
        }
        ?>

        <hr>
        <form class="row" method="POST" enctype="multipart/form-data">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="filename" placeholder="File name" name="filename" required>
                    <label for="filename">File name</label>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Write file</button>
            </div>
        </form>

        <?php
        // Xử lý ghi file
        if (isset($_POST['submit'])) {
            $filename = $_POST['filename'];

            // Ghi file (sẽ ghi đè lên file nếu nó đã tồn tại)
            if (file_put_contents($filename, "Nội dung ghi vào file") !== false) {
                echo '<div class="alert alert-success" role="alert">Ghi file thành công: ' . htmlspecialchars($filename) . '</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Có lỗi khi ghi file.</div>';
            }
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>

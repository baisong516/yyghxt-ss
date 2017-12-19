<?php
$servername = "119.23.71.145";
$username = "aiden";
$password = "adming";

// 创建连接
$conn = new mysqli($servername, $username, $password);

// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
echo "连接成功";
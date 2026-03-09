<?php

namespace App\Models;

class Order
{
    private $connection;

    public function __construct()
    {
        $host = DB_HOST;
        $username = DB_USER;
        $password = DB_PASSWORD;
        $database = DB_NAME;

        $this->connection = new \mysqli($host, $username, $password, $database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    
    public function getAllDonhang()
    {
        $result = $this->connection->query("SELECT * FROM donhang");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    
    public function getDonhangById($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM donhang WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    
    public function createDonhang($userId, $tongTien, $ngayDat, $trangThai, $thongTinGiaoHang)
    {
    $userId = (int)$userId;
    $tongTien = (float)$tongTien;

    
    $sql = "INSERT INTO donhang (userId, tongTien, ngayDat, trangThai, thongTinGiaoHang) VALUES (?, ?, ?, ?, ?)";
            
    $stmt = $this->connection->prepare($sql);
    
    if (!$stmt) {
        die("Lỗi Prepare SQL: " . $this->connection->error);
    }
    
    $stmt->bind_param("idsss", $userId, $tongTien, $ngayDat, $trangThai, $thongTinGiaoHang);
    return $stmt->execute();
    }

    
    public function updateDonhang($id, $userId, $tongTien, $ngayDat, $trangThai, $thongTinGiaoHang)
    {
        $id = (int)$id;
        $userId = (int)$userId;
        $tongTien = (float)$tongTien;
        if (empty($ngayDat)) $ngayDat = date('Y-m-d H:i:s');

        $stmt = $this->connection->prepare(
            "UPDATE donhang SET userId = ?, tongTien = ?, ngayDat = ?, trangThai = ?, thongTinGiaoHang = ? WHERE id = ?"
        );
        $stmt->bind_param("idsssi", $userId, $tongTien, $ngayDat, $trangThai, $thongTinGiaoHang, $id);
        return $stmt->execute(); 
    }

    
    public function deleteDonhang($id)
    {
        $id = (int)$id;
        $stmt = $this->connection->prepare("DELETE FROM donhang WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute(); 
    }
    public function countOrders()
    {
        
        $result = $this->connection->query("SELECT COUNT(*) as total FROM donhang");
        $data = $result->fetch_assoc();
        return (int)($data['total'] ?? 0);
    }
    public function getError() {
    return $this->connection->error;
    }
}
<?php

class Role {
    private $conn;
    private $table_name = "roles";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách tất cả roles
    public function getAllRoles() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy role theo ID
    public function getRoleById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo role mới
    public function createRole($name, $description) {
        $query = "INSERT INTO " . $this->table_name . " (name, description) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        return $stmt->execute();
    }

    // Cập nhật role
    public function updateRole($id, $name, $description) {
        $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        return $stmt->execute();
    }

    // Xóa role
    public function deleteRole($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Lấy permissions của role
    public function getRolePermissions($role_id) {
        $query = "SELECT p.* FROM permissions p 
                 INNER JOIN role_permissions rp ON p.id = rp.permission_id 
                 WHERE rp.role_id = :role_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":role_id", $role_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm permission cho role
    public function addPermissionToRole($role_id, $permission_id) {
        $query = "INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":role_id", $role_id);
        $stmt->bindParam(":permission_id", $permission_id);
        return $stmt->execute();
    }

    // Xóa permission khỏi role
    public function removePermissionFromRole($role_id, $permission_id) {
        $query = "DELETE FROM role_permissions WHERE role_id = :role_id AND permission_id = :permission_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":role_id", $role_id);
        $stmt->bindParam(":permission_id", $permission_id);
        return $stmt->execute();
    }

    // Kiểm tra xem role có permission không
    public function hasPermission($role_id, $permission_name) {
        $query = "SELECT COUNT(*) as count FROM role_permissions rp 
                 INNER JOIN permissions p ON rp.permission_id = p.id 
                 WHERE rp.role_id = :role_id AND p.name = :permission_name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":role_id", $role_id);
        $stmt->bindParam(":permission_name", $permission_name);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }

    // Lấy roles của user
    public function getUserRoles($user_id) {
        $query = "SELECT r.* FROM " . $this->table_name . " r 
                 INNER JOIN user_roles ur ON r.id = ur.role_id 
                 WHERE ur.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm role cho user
    public function addRoleToUser($user_id, $role_id) {
        $query = "INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":role_id", $role_id);
        return $stmt->execute();
    }

    // Xóa role khỏi user
    public function removeRoleFromUser($user_id, $role_id) {
        $query = "DELETE FROM user_roles WHERE user_id = :user_id AND role_id = :role_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":role_id", $role_id);
        return $stmt->execute();
    }

    // Kiểm tra xem user có role không
    public function userHasRole($user_id, $role_name) {
        $query = "SELECT COUNT(*) as count FROM user_roles ur 
                 INNER JOIN roles r ON ur.role_id = r.id 
                 WHERE ur.user_id = :user_id AND r.name = :role_name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":role_name", $role_name);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }
} 
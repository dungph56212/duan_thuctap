<?php

class CommentTag {
    private $conn;
    private $table_name = "comment_tags";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách tất cả thẻ
    public function getAllTags() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thẻ theo ID
    public function getTagById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo thẻ mới
    public function createTag($name, $color = '#000000') {
        $query = "INSERT INTO " . $this->table_name . " (name, color) VALUES (:name, :color)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":color", $color);
        return $stmt->execute();
    }

    // Cập nhật thẻ
    public function updateTag($id, $name, $color) {
        $query = "UPDATE " . $this->table_name . " SET name = :name, color = :color WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":color", $color);
        return $stmt->execute();
    }

    // Xóa thẻ
    public function deleteTag($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Gắn thẻ cho bình luận
    public function addTagToComment($comment_id, $tag_id) {
        $query = "INSERT INTO comment_tag_relations (comment_id, tag_id) VALUES (:comment_id, :tag_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":comment_id", $comment_id);
        $stmt->bindParam(":tag_id", $tag_id);
        return $stmt->execute();
    }

    // Xóa thẻ khỏi bình luận
    public function removeTagFromComment($comment_id, $tag_id) {
        $query = "DELETE FROM comment_tag_relations WHERE comment_id = :comment_id AND tag_id = :tag_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":comment_id", $comment_id);
        $stmt->bindParam(":tag_id", $tag_id);
        return $stmt->execute();
    }

    // Lấy thẻ của bình luận
    public function getCommentTags($comment_id) {
        $query = "SELECT t.* FROM " . $this->table_name . " t 
                 INNER JOIN comment_tag_relations r ON t.id = r.tag_id 
                 WHERE r.comment_id = :comment_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":comment_id", $comment_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy bình luận theo thẻ
    public function getCommentsByTag($tag_id, $limit = 50, $offset = 0) {
        $query = "SELECT b.* FROM binh_luan b 
                 INNER JOIN comment_tag_relations r ON b.id = r.comment_id 
                 WHERE r.tag_id = :tag_id 
                 ORDER BY b.created_at DESC 
                 LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tag_id", $tag_id);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy số lượng bình luận theo thẻ
    public function getCommentCountByTag($tag_id) {
        $query = "SELECT COUNT(*) as count FROM comment_tag_relations WHERE tag_id = :tag_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tag_id", $tag_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'];
    }

    // Lấy thống kê thẻ
    public function getTagStats() {
        $query = "SELECT t.*, COUNT(r.comment_id) as comment_count 
                 FROM " . $this->table_name . " t 
                 LEFT JOIN comment_tag_relations r ON t.id = r.tag_id 
                 GROUP BY t.id 
                 ORDER BY comment_count DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tìm kiếm thẻ
    public function searchTags($keyword) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE name LIKE :keyword 
                 ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(":keyword", $keyword);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 
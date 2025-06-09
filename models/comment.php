<?php 
    class commentModel{
        public $conn;

        public function __construct(){
            $this->conn = connectDB();
        }

        public function add_comment($san_pham_id, $tai_khoan_id, $noi_dung){
            try {
                // Sanitize input
                $noi_dung = htmlspecialchars(trim($noi_dung), ENT_QUOTES, 'UTF-8');
                
                // Default status - pending approval for new users
                $trang_thai = 1; // 1 = pending, 2 = approved, 3 = rejected
                $ngay_dang = date('Y-m-d H:i:s');
                
                $sql = 'INSERT INTO binh_luans (san_pham_id, tai_khoan_id, noi_dung, ngay_dang, trang_thai)
                VALUES (:san_pham_id, :tai_khoan_id, :noi_dung, :ngay_dang, :trang_thai)';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':san_pham_id' => $san_pham_id,
                    ':tai_khoan_id' => $tai_khoan_id,
                    ':noi_dung' => $noi_dung,
                    ':ngay_dang' => $ngay_dang,
                    ':trang_thai' => $trang_thai,
                ]);
                return $this->conn->lastInsertId();
            } catch (PDOException $th) {
                error_log("Comment add error: " . $th->getMessage());
                return false;
            }
        }

        public function get_comment_by_id($comment_id) {
            try {
                $sql = 'SELECT bl.*, tk.ho_ten, tk.anh_dai_dien 
                        FROM binh_luans bl 
                        INNER JOIN tai_khoans tk ON bl.tai_khoan_id = tk.id 
                        WHERE bl.id = :comment_id';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([':comment_id' => $comment_id]);
                return $stmt->fetch();
            } catch (PDOException $th) {
                error_log("Get comment error: " . $th->getMessage());
                return false;
            }
        }

        public function update_comment($comment_id, $noi_dung, $tai_khoan_id) {
            try {
                // Check if user owns this comment
                $comment = $this->get_comment_by_id($comment_id);
                if (!$comment || $comment['tai_khoan_id'] != $tai_khoan_id) {
                    return false;
                }

                $noi_dung = htmlspecialchars(trim($noi_dung), ENT_QUOTES, 'UTF-8');
                $ngay_cap_nhat = date('Y-m-d H:i:s');
                
                $sql = 'UPDATE binh_luans 
                        SET noi_dung = :noi_dung, ngay_cap_nhat = :ngay_cap_nhat 
                        WHERE id = :comment_id AND tai_khoan_id = :tai_khoan_id';
                $stmt = $this->conn->prepare($sql);
                return $stmt->execute([
                    ':noi_dung' => $noi_dung,
                    ':ngay_cap_nhat' => $ngay_cap_nhat,
                    ':comment_id' => $comment_id,
                    ':tai_khoan_id' => $tai_khoan_id
                ]);
            } catch (PDOException $th) {
                error_log("Update comment error: " . $th->getMessage());
                return false;
            }
        }

        public function delete_comment($comment_id, $tai_khoan_id) {
            try {
                // Check if user owns this comment
                $comment = $this->get_comment_by_id($comment_id);
                if (!$comment || $comment['tai_khoan_id'] != $tai_khoan_id) {
                    return false;
                }

                $sql = 'DELETE FROM binh_luans WHERE id = :comment_id AND tai_khoan_id = :tai_khoan_id';
                $stmt = $this->conn->prepare($sql);
                return $stmt->execute([
                    ':comment_id' => $comment_id,
                    ':tai_khoan_id' => $tai_khoan_id
                ]);
            } catch (PDOException $th) {
                error_log("Delete comment error: " . $th->getMessage());
                return false;
            }
        }

        public function get_user_comments_count($tai_khoan_id) {
            try {
                $sql = 'SELECT COUNT(*) as count FROM binh_luans WHERE tai_khoan_id = :tai_khoan_id';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([':tai_khoan_id' => $tai_khoan_id]);
                $result = $stmt->fetch();
                return $result['count'];
            } catch (PDOException $th) {
                error_log("Get user comments count error: " . $th->getMessage());
                return 0;
            }
        }

        public function can_user_comment($tai_khoan_id, $san_pham_id) {
            try {
                // Check if user has already commented on this product in the last 24 hours
                $sql = 'SELECT COUNT(*) as count FROM binh_luans 
                        WHERE tai_khoan_id = :tai_khoan_id 
                        AND san_pham_id = :san_pham_id 
                        AND ngay_dang > DATE_SUB(NOW(), INTERVAL 24 HOUR)';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':tai_khoan_id' => $tai_khoan_id,
                    ':san_pham_id' => $san_pham_id
                ]);
                $result = $stmt->fetch();
                return $result['count'] < 3; // Allow max 3 comments per day per product
            } catch (PDOException $th) {
                error_log("Can user comment error: " . $th->getMessage());
                return false;
            }
        }

        public function validate_comment($noi_dung) {
            $errors = [];
            
            if (empty(trim($noi_dung))) {
                $errors[] = "Nội dung bình luận không được để trống";
            }
            
            if (strlen(trim($noi_dung)) < 10) {
                $errors[] = "Nội dung bình luận phải có ít nhất 10 ký tự";
            }
            
            if (strlen(trim($noi_dung)) > 1000) {
                $errors[] = "Nội dung bình luận không được vượt quá 1000 ký tự";
            }
            
            // Check for spam patterns
            $spam_patterns = ['http://', 'https://', 'www.', '.com', '.vn', 'click here', 'buy now'];
            foreach ($spam_patterns as $pattern) {
                if (stripos($noi_dung, $pattern) !== false) {
                    $errors[] = "Nội dung bình luận không được chứa liên kết hoặc từ khóa spam";
                    break;
                }
            }
            
            return $errors;
        }

        public function get_approved_comments_by_product($san_pham_id) {
            try {
                $sql = 'SELECT bl.*, tk.ho_ten, tk.anh_dai_dien,
                               ar.noi_dung as admin_reply, ar.ngay_dang as admin_reply_date
                        FROM binh_luans bl 
                        INNER JOIN tai_khoans tk ON bl.tai_khoan_id = tk.id 
                        LEFT JOIN binh_luans ar ON ar.parent_id = bl.id AND ar.is_admin_reply = 1
                        WHERE bl.san_pham_id = :san_pham_id 
                        AND bl.trang_thai = 2 
                        AND bl.parent_id IS NULL
                        ORDER BY bl.ngay_dang DESC';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([':san_pham_id' => $san_pham_id]);
                return $stmt->fetchAll();
            } catch (PDOException $th) {
                error_log("Get approved comments error: " . $th->getMessage());
                return [];
            }
        }
    }
?>
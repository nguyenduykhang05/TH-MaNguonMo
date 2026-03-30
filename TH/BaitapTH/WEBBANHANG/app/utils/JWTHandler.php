<?php

require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHandler
{
    private $secret_key;

    public function __construct()
    {
        // Khóa bí mật phải có ít nhất 32 ký tự cho thuật toán HS256
        $this->secret_key = "HUTECH_SECRET_KEY_2024_FOR_API_SECURITY_JWT_AUTH"; 
    }

    // Tạo JWT Token từ dữ liệu mảng
    public function encode($data)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // Token có hiệu lực trong 1 giờ
        $payload = array(
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $data
        );

        return JWT::encode($payload, $this->secret_key, 'HS256');
    }

    // Giải mã JWT Token để lấy dữ liệu mảng
    public function decode($jwt)
    {
        try {
            $decoded = JWT::decode($jwt, new Key($this->secret_key, 'HS256'));
            return (array) $decoded->data;
        } catch (Exception $e) {
            return null; // Trả về null nếu token không hợp lệ hoặc hết hạn
        }
    }
}
?>

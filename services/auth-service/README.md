# Auth Service

Auth Service dành cho hệ thống quản lý bệnh viện. Service này sử dụng email làm khóa chính để xác thực người dùng và cung cấp thông tin cho các service khác.

## Cấu trúc Database

### Bảng `users`

- `id`: ID tự tăng
- `email`: Email người dùng (unique)
- `password_hash`: Mật khẩu đã hash
- `role`: Vai trò (PATIENT, DOCTOR, STAFF, ADMIN)
- `created_at`: Thời gian tạo
- `updated_at`: Thời gian cập nhật

## API Endpoints

### 1. Đăng nhập

```
POST /api/auth/login
Content-Type: application/json

{
  "email": "alice@example.com",
  "password": "password123"
}
```

### 2. Đăng ký

```
POST /api/auth/register
Content-Type: application/json

{
  "email": "newuser@example.com",
  "password": "password123",
  "role": "PATIENT"
}
```

### 3. Làm mới token

```
POST /api/auth/refresh
Content-Type: application/json

{
  "refreshToken": "your-refresh-token"
}
```

### 4. Lấy thông tin người dùng từ token

```
GET /api/auth/user
Authorization: Bearer your-jwt-token
```

### 5. Lấy thông tin người dùng từ email

```
GET /api/auth/user/{email}
```

## Tích hợp với các service khác

Các service khác có thể sử dụng endpoint `/api/auth/user/{email}` để lấy thông tin người dùng dựa trên email:

```json
{
  "userId": 1,
  "email": "alice@example.com",
  "role": "PATIENT"
}
```

## Cấu hình

Cập nhật file `application.properties`:

```properties
# Database
spring.datasource.url=jdbc:mysql://localhost:3306/auth_db
spring.datasource.username=root
spring.datasource.password=your-password

# JWT
jwt.secret=your-secret-key
jwt.expiration=86400000
jwt.refresh-expiration=604800000
```

## Chạy ứng dụng

1. Tạo database:

```sql
mysql -u root -p < auth_db_schema.sql
```

2. Chạy ứng dụng:

```bash
mvn spring-boot:run
```

3. Test API:

```bash
curl -X POST http://localhost:8081/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"alice@example.com","password":"password123"}'
```

## Tài khoản test

- Email: `alice@example.com`, Password: `password123`, Role: `PATIENT`
- Email: `dr.hoa@example.com`, Password: `password123`, Role: `DOCTOR`
- Email: `admin@hospital.com`, Password: `password123`, Role: `ADMIN`

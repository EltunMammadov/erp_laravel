Layihə haqqında

Bu layihə Authentication + Sadə ERP (Enterprise Resource Planning) sistemi kimi hazırlanmışdır. Sistem istifadəçilərin qeydiyyatı, giriş, rol əsaslı icazələr və əsas biznes modullarını (məhsul, müştəri, sifariş, hesabatlar) əhatə edir.

Layihə təmiz arxitektura, təhlükəsizlik best practice-ləri və real production yanaşması ilə hazırlanmışdır.

 Texnologiyalar
PHP 8.2+
Laravel 11
Laravel Sanctum (Authentication)
MySQL / PostgreSQL
Eloquent ORM
Queue (Database driver)
Mailtrap (Email testing üçün)
PHPUnit / Pest (Testing)
 Arxitektura

Layihə Layered Architecture prinsiplərinə uyğun hazırlanmışdır:

Controller → Service → Repository → Model

Əlavə olaraq:

Policies → Authorization üçün
Form Request → Validation üçün
Events & Listeners → Stock update kimi proseslər üçün
API Resources → Response standardizasiyası üçün
 Authentication & Security
 İmkanlar
Qeydiyyat (email verification ilə)
Login (Token-based auth – Sanctum)
Password reset (token ilə, 1 saat aktiv)
Change password (authenticated)
Account lock (5 uğursuz cəhddən sonra 15 dəq)
Login attempt log (IP + timestamp)
 Təhlükəsizlik
Password hashing: bcrypt
Rate limiting (login endpoint)
Role-based access control (RBAC)
Email verification məcburidir
 Rol Sistemi
Rol	Səlahiyyət
admin	Tam access
manager	Məhsul, sifariş, müştəri idarəsi
employee	Yalnız təyin olunan sifarişlər
 Modullar
1. Product Management
Məhsul CRUD
SKU auto-generate (PRD-XXXXX)
Low stock endpoint
Soft delete
Business rule:
Pending/processing order varsa silinmir
2. Customer Management
Müştəri CRUD
Order history summary
Business rules:
business tipdə tax_id məcburidir
Aktiv sifarişi olan müştəri silinmir
3. Order Management
Order + order_items strukturu
Status flow:
draft → pending → processing → shipped → delivered
        ↘ cancelled
Business logic:
Stock azaldılır (processing zamanı)
Cancel olduqda stock geri qaytarılır
Total amount server-side hesablanır
4. Dashboard & Reports
Ümumi statistikalar
Revenue analizi
Top products & customers
Inventory report (critical / low / normal)

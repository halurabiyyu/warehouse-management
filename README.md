# 🚀 Final Boss (Laravel + Docker)

This project is a **Laravel application** running with **Docker**, using:
- **PHP 8.4 (FPM)**
- **Nginx**
- **MySQL 8.0**

---

## 📦 Requirements

Make sure you have these installed:
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- (Optional) [Git](https://git-scm.com/)

---

## ⚙️ Installation & Setup

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/your-username/final-boss.git
cd final-boss
```

### 2️⃣ Copy .env file
```bash
cp .env.example .env
```

Update your `.env` file for database connection:
```env
DB_CONNECTION=mysql
DB_HOST=pbl_db
DB_PORT=3306
DB_DATABASE=pbl
DB_USERNAME=root
DB_PASSWORD=root
```

### 3️⃣ Start Docker Containers
```bash
docker compose up -d --build
```

This will start:
- **pbl_app** → PHP (Laravel)
- **pbl_nginx** → Nginx (accessible at http://localhost:8022)
- **pbl_db** → MySQL (accessible on port 3307)

### 4️⃣ Install Dependencies
Run Composer and NPM inside the PHP container:
```bash
docker exec -it pbl_app composer install
docker exec -it pbl_app npm install && npm run dev
```

### 5️⃣ Generate Laravel Key
```bash
docker exec -it pbl_app php artisan key:generate
```

### 6️⃣ Run Database Migrations
```bash
docker exec -it pbl_app php artisan migrate
```

(Optional) Seed data:
```bash
docker exec -it pbl_app php artisan db:seed
```

---

## 🔧 Useful Commands

### Stop containers
```bash
docker compose down
```

### Rebuild containers (after changing Dockerfile / docker-compose.yml)
```bash
docker compose up -d --build
```

### Access PHP container
```bash
docker exec -it pbl_app bash
```

### Run Artisan commands
```bash
docker exec -it pbl_app php artisan <command>
```

---

## 🌐 Access

- **App** → http://localhost:8022
- **MySQL** → localhost:3307
  - Username: `root`
  - Password: `root`
  - Database: `pbl`

---

## 🛠️ Troubleshooting

### ❌ Public Key Retrieval is not allowed

MySQL 8 uses `caching_sha2_password` by default. Some clients fail unless you allow public key retrieval.

**✅ Fix:** In Laravel `.env`, add:
```env
DB_CONNECTION=mysql
DB_HOST=pbl_db
DB_PORT=3306
DB_DATABASE=pbl
DB_USERNAME=root
DB_PASSWORD=root
DB_OPTIONS='--default-auth=mysql_native_password'
```

Or in DBeaver / MySQL Workbench → Connection settings → Driver properties:
```ini
allowPublicKeyRetrieval=true
useSSL=false
```

### ❌ SQLSTATE[HY000] [2002] Connection refused

Happens if you connect using `localhost` instead of the Docker service name.

**✅ Fix in .env:**
```env
DB_HOST=pbl_db
DB_PORT=3306
```

For external clients (like DBeaver, TablePlus, etc.), connect with:
```yaml
Host: 127.0.0.1
Port: 3307
User: root
Password: root
Database: pbl
```
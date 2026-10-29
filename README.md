# 文章管理系統 (Article Management System)

這是一個基於前後端分離架構設計的文章管理系統。後端使用 **Laravel 10** 提供 RESTful API，前端採用 **Vue 3 + Vite** 打造現代化的單頁應用程式（SPA）。支援文章、分類與標籤的完整 CRUD 操作及多對多關聯管理。

---

## 📌 功能特色

- **文章管理 (Articles)**：
  - 文章列表瀏覽與分頁功能 (`@hennge/vue3-pagination`)
  - 文章新增、編輯與刪除 (CRUD)
  - 分類關聯（一對多）
  - 標籤多選關聯與同步 (`sync` / `attach`)
- **分類管理 (Categories)**：
  - 文章分類的新增、查看、修改與刪除
  - 級聯刪除保護或聯動
- **標籤管理 (Tags)**：
  - 文章標籤的獨立管理 (CRUD)
- **友善的使用者介面**：
  - 基於 Bootstrap 5 的響應式設計
  - 整合 SweetAlert2 提供友善的操作回饋與確認提示

---

## 🛠️ 技術棧 (Tech Stack)

### 後端 (Backend)
- **框架**：Laravel 10.x
- **語言**：PHP 8.1+
- **資料庫**：MySQL / MariaDB
- **身份驗證與工具**：Laravel Sanctum, Guzzle

### 前端 (Frontend)
- **核心框架**：Vue 3 (Composition API / Options API)
- **建置工具**：Vite
- **路由管理**：Vue Router 4
- **網路請求**：Axios
- **UI 樣式與元件**：Bootstrap 5
- **分頁元件**：`@hennge/vue3-pagination`
- **彈跳視窗**：SweetAlert2

---

## 📂 專案目錄結構

```text
article_management/
├── article_management_laravel/   # Laravel 10 後端專案
│   ├── app/
│   │   ├── Http/Controllers/Api/  # RESTful API 控制器 (Article, Category, Tag)
│   │   └── Models/                # Eloquent 模型與關聯
│   ├── database/migrations/       # 資料庫遷移檔
│   ├── routes/api.php             # API 路由設定
│   └── .env.example
├── article_management_vue/       # Vue 3 前端專案
│   ├── src/
│   │   ├── views/                 # 各頁面組件 (Articles, Categories, Tags)
│   │   ├── router/                # 路由配置
│   │   └── App.vue
│   └── package.json
└── README.md
```

---

## 🚀 快速開始 (Quick Start)

### 1. 環境需求
請確保您的開發環境已安裝：
- [PHP](https://www.php.net/) >= 8.1
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) (建議 LTS 版本) & npm
- [MySQL](https://www.mysql.com/)

---

### 2. 後端建置 (Laravel)

進入後端目錄並進行環境設定：

```bash
cd article_management_laravel

# 1. 安裝 Composer 依賴套件
composer install

# 2. 複製環境變數設定檔
cp .env.example .env

# 3. 產生應用程式金鑰
php artisan key:generate
```

編輯 `.env` 檔案以連接您的資料庫：
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=article_management
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

執行資料庫遷移（Migration）：
```bash
php artisan migrate
```

啟動後端伺服器：
```bash
php artisan serve
```
> 後端 API 預設將運行於 `http://127.0.0.1:8000`

---

### 3. 前端建置 (Vue 3)

打開新的終端機視窗，進入前端目錄：

```bash
cd article_management_vue

# 1. 安裝 npm 依賴套件
npm install

# 2. 啟動開發環境伺服器
npm run dev
```
> 前端應用程式預設運行於 `http://localhost:5173`

---

## 📡 API 路由概覽

所有 API 路由皆前綴 `/api/`：

| HTTP 方法 | 路由 | 說明 |
| :--- | :--- | :--- |
| `GET` | `/api/articles` | 獲取分頁文章列表 |
| `POST` | `/api/articles` | 建立新文章 |
| `GET` | `/api/articles/{id}` | 取得指定文章詳情 |
| `GET` | `/api/articles/{id}/edit` | 取得欲編輯的文章資料（含標籤） |
| `PUT` | `/api/articles/{id}` (亦相容 `/edit`) | 更新指定文章 |
| `DELETE` | `/api/articles/{id}` (亦相容 `/delete`) | 刪除指定文章 |
| `GET` | `/api/categories` | 獲取分類列表 |
| `POST` | `/api/categories` | 建立新分類 |
| `GET` | `/api/categories/{id}` | 取得指定分類資料 |
| `PUT` | `/api/categories/{id}` (亦相容 `/edit`) | 更新指定分類 |
| `DELETE` | `/api/categories/{id}` (亦相容 `/delete`) | 刪除指定分類 |
| `GET` | `/api/tags` | 獲取標籤列表 |
| `POST` | `/api/tags` | 建立新標籤 |
| `GET` | `/api/tags/{id}` | 取得指定標籤資料 |
| `PUT` | `/api/tags/{id}` (亦相容 `/edit`) | 更新指定標籤 |
| `DELETE` | `/api/tags/{id}` (亦相容 `/delete`) | 刪除指定標籤 |

---

## 📄 授權條款 (License)

本專案基於 [MIT License](LICENSE) 條款開放開源使用。

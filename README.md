# 🚀 Enterprise ERP & POS System

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Platform: Ubuntu](https://img.shields.io/badge/Platform-Ubuntu%2022.04%2B-orange.svg)](https://ubuntu.com/)
[![Database: MySQL](https://img.shields.io/badge/DB-MySQL-blue.svg)](https://www.mysql.com/)

Manage **Your Entire Business** in one place. Streamline operations, boost sales, and gain real-time insights with our unified ERP and POS platform built for modern enterprises.

---

## 🛠️ Quick Installation

Follow these steps to get your environment running on an Ubuntu-based server.

### 1. Server Preparation
Run the automated setup script to install dependencies (PHP, Apache/Nginx, etc.):
- chmod +x admin/setup_ubuntu.sh
- ./admin/setup_ubuntu.sh

### 2. Database Configuration
1. Import the core database schema:
   - mysql -u your_user -p your_database < mayzar.sql
2. Configure your connection by editing `config.php` with your DB credentials.

### 3. Assets & Localization
> [!IMPORTANT]
> **Legacy Assets:** Ensure you upload the `assets/` folder from the earlier version to the root directory to maintain UI consistency.

* **Translations:** Language strings can be managed and updated via `admin/lang.php`.

---

## 📂 Project Structure

| Path | Description |
| :--- | :--- |
| admin/ | Contains administrative scripts and language controllers. |
| config.php | Global system and database configuration. |
| mayzar.sql | Primary database architecture. |
| assets/ | Frontend resources (CSS, JS, Images). |

---

## 💡 Key Features

* **Unified Dashboard:** Manage your entire business in one place.
* **Real-time Analytics:** Gain instant insights into your sales performance.
* **POS Integration:** Seamlessly connect retail point-of-sale with back-end ERP.
* **Multi-language:** Easy string management via `admin/lang.php`.

---

## 🤝 Contributing

1. Fork the Project.
2. Create your Feature Branch.
3. Commit your Changes.
4. Push to the Branch.
5. Open a Pull Request.

---
© 2026 Enterprise Solutions. Built for the modern web.

# 🌱 AgroTech — Platform to Support Small Rural Businesses

Welcome to the **AgroTech Project** repository — a web system designed to help **small businesses and family farmers** present and manage their products easily, efficiently, and professionally.

This project is part of the **TSI — Internet Systems Technology** course at the **Federal Institute of Brasília (IFB)**.

## 👥 Team Members

* **Pedro Neto**
* **Felipe Dias**
* **Endryo Matos**
* **Felipe Madson**

## 🏫 Institution

**Federal Institute of Brasília — IFB**

## 🚀 Technologies Used

AgroTech is being developed using:

* **HTML** — Page structure
* **CSS** — Layout and styling
* **JavaScript** — Front-end interactivity
* **PHP** — Business logic and back-end
* **MySQL** — Database management

---

# 📁 Project Structure

The project follows a clean and professional structure to ensure organization, easy maintenance, and scalability.

```
PROJETO-AGROTECH/
│
└── src/
    │
    ├── views/                    ← User interface pages (HTML/PHP)
    │     index.php
    │     login.php
    │     cadastro.php
    │     redefinir-senha.php
    │     selecionarLocal.php
    │     vendedor.php
    │     verificar.php
    │     img/                   ← Pages grouped by category
    │         galeria.php
    │         carro.php
    │
    ├── controllers/             ← Application logic and actions
    │     loginController.php
    │     cadastroController.php
    │     verificarController.php
    │     compraController.php
    │
    ├── includes/                ← Reusable components
    │     header.php
    │     footer.php
    │     menu.php
    │     auth.php
    │
    ├── config/                  ← Configuration files
    │     db.php
    │     logs/
    │     database/
    │         agrotech.sql
    │         migrate_add_preco.sql
    │
    └── public/                  ← Assets accessible by the browser
          └── assets/
              ├── css/
              ├── js/
              └── img/
```

### ✨ Folder Breakdown

* **views/** — Interface pages shown to the user.
* **controllers/** — Files responsible for processing logic.
* **includes/** — Headers, footers, menus, and reusable components.
* **config/** — Database connection, logs, and migrations.
* **public/** — Files accessible by the browser.
* **assets/** — CSS, JS, and images.

---

# 🔧 PHP Integration — AgroTech (carrot)

Below are the key files involved in the PHP/MySQL integration:

* **db.php** — PDO connection setup.
* **carrot.php** — Dynamic page that fetches data for the "Carrot" product.
* **add_to_cart.php** — Handles cart operations using PHP sessions.
* **buy.php** — Registers sales, adds sale items, and updates inventory.
* **migrate_add_preco.sql** — Adds a `preco` column to the `produtos` table.

---

# 🖥️ How to Run the Project Locally (Windows — XAMPP)

## 1. Install XAMPP

Download from: [https://www.apachefriends.org/](https://www.apachefriends.org/)

## 2. Place the project inside htdocs

Move the **PROJETO-AGROTECH** folder to:

```
C:/xampp/htdocs/agrotech
```

## 3. Start the services

In the XAMPP control panel, activate:

* ✔ Apache
* ✔ MySQL

## 4. Import the database

In phpMyAdmin:

* Create a database named `agrotech`
* Import **agrotech.sql**
* If needed, run **migrate_add_preco.sql**

## 5. Open in the browser

```
http://localhost/agrotech/index.php
```

---

# 🌐 How to Host Using GitHub Pages

> ⚠ GitHub Pages DOES NOT run PHP.
> It supports only HTML/CSS/JS.

Still, you can host the static part of the website:

## 1. Download the repository

```
git clone https://github.com/yourUser/yourRepository.git
```

## 2. Place static files at the root

Example:

```
/index.html
/assets/css/
/assets/js/
/assets/img/
```

## 3. Go to GitHub → Settings → Pages

* Build from: **Main Branch**
* Folder: **root**

## 4. GitHub will generate a link such as:

```
https://yourUser.github.io/yourRepository/
```

---

# 🔥 How to Preview the Site Using VSCode (Live Server)

## For HTML files:

1. Install **Live Server** extension.
2. Right-click `index.html` → **Open with Live Server**.

## For PHP files:

1. Install **PHP Server** extension.
2. Use: **PHP Server: Serve Project**.

---

# 📌 Next Steps for the Project

* Implement full authentication system with access levels.
* Improve the shopping cart and checkout.
* Add pages for sellers.
* Improve responsiveness and accessibility.
* Integrate with payment gateways.
* Build an admin dashboard.

---

# 🤝 Contributing

Feel free to contribute by opening issues or pull requests.

# 📄 License

This project is intended for educational use and academic development.

---

Made with ❤️ by the AgroTec team.



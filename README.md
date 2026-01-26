# 🛒 E-Commerce Laravel - README

---

## 📌 Table des Matières

- [Présentation](#présentation)
- [Fonctionnalités](#fonctionnalités)
- [Technologies](#technologies)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [Structure du Projet](#structure-du-projet)
- [Base de Données](#base-de-données)
- [Tests](#tests)
- [Développement](#développement)
- [Contribuer](#contribuer)
- [License](#license)

---

## 📝 Présentation

**E-Commerce Laravel** est une application web de gestion de boutique en ligne développée avec le framework Laravel. Ce projet permet aux administrateurs de gérer les catégories et les produits, tout en offrant une interface publique pour la consultation et la navigation.

---

## ✨ Fonctionnalités

### 🔐 Authentification
- Connexion sécurisée pour les administrateurs
- Protection des routes back-office
- Gestion des sessions

### 📦 Gestion des Catégories (Back-office)
- Création, modification, suppression et affichage des catégories
- Champs : `id`, `nom`, `slug`, `description`
- Génération automatique des slugs
- Validation côté serveur

### 🛍️ Gestion des Produits (Back-office)
- Création, modification, suppression et affichage des produits
- Champs : `id`, `nom`, `référence`, `description courte`, `prix`, `stock`, `catégorie_id`, `image`
- Upload d'images produits
- Validation des prix et du stock (stock ≥ 0)
- Assignation aux catégories

### 🌐 Interface Publique
- Page de liste des catégories
- Page de liste des produits par catégorie (avec pagination)
- Page de détail produit
- Navigation fluide et responsive

### 🧪 Bonus (Optionnels)
- SoftDeletes pour la restauration des éléments supprimés
- Seeders et Factories pour le peuplement de la base
- Recherche simple par nom de produit
- Filtres par catégorie

---

## 🛠️ Technologies

| Technologie | Version |
|-------------|---------|
| **Laravel** | 10.x (stable) |
| **PHP** | 8.1+ |
| **MySQL / MariaDB** | 8.0+ / 10.4+ |
| **Blade** | Intégré à Laravel |
| **Laravel Breeze** | Pour l'authentification |
| **HTML / CSS / JavaScript** | Vanilla (pas de SPA) |

---

## 📋 Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- **PHP** 8.1 ou supérieur
- **Composer** (gestionnaire de dépendances PHP)
- **MySQL** ou **MariaDB**
- **Node.js** et **npm** (pour les assets optionnels)
- **Git**

---

## 🚀 Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/votre-utilisateur/ecommerce-laravel.git
cd ecommerce-laravel
```

### 2. Installer les dépendances

```bash
composer install
npm install  # Optionnel, pour les assets
```

### 3. Configurer l'environnement

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurer la base de données

Dans le fichier `.env`, mettez à jour les informations de votre base de données :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_db
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
```

### 5. Créer la base de données

```bash
mysql -u root -p
CREATE DATABASE ecommerce_db;
exit;
```

### 6. Exécuter les migrations

```bash
php artisan migrate
```

### 7. Exécuter les seeders (optionnel)

```bash
php artisan db:seed
```

### 8. Lancer le serveur de développement

```bash
php artisan serve
```

L'application sera accessible à l'adresse : **http://localhost:8000**

---

## ⚙️ Configuration

### Storage (Uploads d'images)

```bash
php artisan storage:link
```

Les images uploadées seront stockées dans `storage/app/public/products/` et accessibles via `public/storage/products/`.

### Permissions

Assurez-vous que les dossiers suivants sont accessibles en écriture :

```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### Variables d'environnement importantes

```env
# Application
APP_NAME="E-Commerce Laravel"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

# Session
SESSION_LIFETIME=120

# File Uploads
MAX_FILE_SIZE=2048  # 2MB
```

---

## 📖 Utilisation

### 🔐 Accès Administrateur

1. Créez un compte administrateur via le formulaire d'inscription ou via Tinker :
   ```bash
   php artisan tinker
   >>> \App\Models\User::create([
       'name' => 'Admin',
       'email' => 'admin@example.com',
       'password' => bcrypt('password'),
       'is_admin' => true
   ]);
   ```

2. Connectez-vous à : **http://localhost:8000/login**

### 📦 Gestion des Catégories

- **URL:** `/admin/categories`
- Actions disponibles : Créer, Modifier, Supprimer, Afficher

### 🛍️ Gestion des Produits

- **URL:** `/admin/products`
- Actions disponibles : Créer, Modifier, Supprimer, Afficher
- Upload d'images supporté (formats : jpg, jpeg, png, gif)

### 🌐 Interface Publique

- **Accueil:** `/`
- **Liste des catégories:** `/categories`
- **Produits par catégorie:** `/categories/{slug}`
- **Détail produit:** `/products/{slug}`

---

## 📁 Structure du Projet

```
ecommerce-laravel/
├── app/
│   ├── Models/
│   │   ├── Category.php
│   │   └── Product.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── CategoryController.php
│   │   │   │   └── ProductController.php
│   │   │   ├── Public/
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   └── HomeController.php
│   │   │   └── Auth/
│   │   │       └── AuthenticatedSessionController.php
│   │   └── Requests/
│   │       ├── StoreCategoryRequest.php
│   │       ├── UpdateCategoryRequest.php
│   │       ├── StoreProductRequest.php
│   │       └── UpdateProductRequest.php
│   └── Policies/
│       └── AdminPolicy.php
├── database/
│   ├── migrations/
│   │   ├── create_categories_table.php
│   │   └── create_products_table.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── CategorySeeder.php
│   │   └── ProductSeeder.php
│   └── factories/
│       ├── CategoryFactory.php
│       └── ProductFactory.php
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   │   ├── categories/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── create.blade.php
│   │   │   │   └── edit.blade.php
│   │   │   └── products/
│   │   │       ├── index.blade.php
│   │   │       ├── create.blade.php
│   │   │       └── edit.blade.php
│   │   ├── public/
│   │   │   ├── categories/
│   │   │   │   ├── index.blade.php
│   │   │   │   └── show.blade.php
│   │   │   ├── products/
│   │   │   │   └── show.blade.php
│   │   │   └── layouts/
│   │   │       ├── app.blade.php
│   │   │       └── guest.blade.php
│   │   └── components/
│   │       └── alert.blade.php
│   └── js/
│       └── app.js
├── routes/
│   ├── web.php
│   └── auth.php
├── storage/
│   └── app/
│       └── public/
│           └── products/
└── tests/
    ├── Feature/
    │   ├── CategoryTest.php
    │   ├── ProductTest.php
    │   └── AuthTest.php
    └── Unit/
        ├── CategoryTest.php
        └── ProductTest.php
```

---

## 💾 Base de Données

### Schéma des Tables

#### `users`
| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Identifiant unique |
| name | string | Nom de l'utilisateur |
| email | string | Email unique |
| email_verified_at | timestamp | Date de vérification |
| password | string | Mot de passe hashé |
| is_admin | boolean | Rôle administrateur |
| remember_token | string | Token de session |
| created_at | timestamp | Date de création |
| updated_at | timestamp | Date de mise à jour |

#### `categories`
| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Identifiant unique |
| name | string | Nom de la catégorie |
| slug | string | Slug unique pour l'URL |
| description | text | Description de la catégorie |
| created_at | timestamp | Date de création |
| updated_at | timestamp | Date de mise à jour |

#### `products`
| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Identifiant unique |
| name | string | Nom du produit |
| reference | string | Référence unique |
| description | text | Description courte |
| price | decimal | Prix du produit |
| stock | integer | Quantité en stock |
| category_id | bigint | Clé étrangère vers categories |
| image | string | Chemin de l'image |
| deleted_at | timestamp | Soft delete (optionnel) |
| created_at | timestamp | Date de création |
| updated_at | timestamp | Date de mise à jour |

---

## 🧪 Tests

### Exécuter les tests

```bash
php artisan test
```

### Tests disponibles

- **Feature Tests:** Tests des fonctionnalités complètes (CRUD, authentification)
- **Unit Tests:** Tests des modèles et méthodes individuelles

### Créer un nouveau test

```bash
php artisan make:test ProductTest
```

---

## 🛠️ Développement

### Créer un contrôleur

```bash
php artisan make:controller Admin/CategoryController --resource
```

### Créer un modèle avec migration

```bash
php artisan make:model Category -m
```

### Créer une migration

```bash
php artisan make:migration create_categories_table
```

### Créer une factory

```bash
php artisan make:factory CategoryFactory --model=Category
```

### Créer un seeder

```bash
php artisan make:seeder CategorySeeder
```

### Créer une Form Request

```bash
php artisan make:request StoreCategoryRequest
```

### Compiler les assets (optionnel)

```bash
npm run dev    # Développement
npm run build  # Production
```

---

## 🤝 Contribuer

### Workflow de contribution

1. Fork le dépôt
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/NomFonctionnalite`)
3. Committez vos changements (`git commit -m 'Ajout de la fonctionnalité X'`)
4. Poussez vers la branche (`git push origin feature/NomFonctionnalite`)
5. Ouvrez une Pull Request

### Standards de code

- Suivez les [PSR-12](https://www.php-fig.org/psr/psr-12/) pour le code PHP
- Utilisez des messages de commit clairs et concis
- Documentez votre code avec des commentaires pertinents


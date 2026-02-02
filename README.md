# 🛒 TifawinSouk – Application Web Laravel (MVC)

## 📌 Présentation du Projet

**TifawinSouk** est une application web monolithique développée avec **Laravel**, destinée à une PME marocaine spécialisée dans le commerce local.  
L’objectif est de digitaliser la gestion des produits, fournisseurs et commandes tout en offrant une vitrine publique pour les clients.

Le projet respecte l’architecture **MVC (Model – View – Controller)** et les bonnes pratiques du framework Laravel.

---

## 🎯 Objectifs

L’application couvre deux espaces distincts :

### 🔐 Back-Office (Admin)
- Gestion du catalogue de produits
- Gestion des catégories
- Gestion des fournisseurs
- Suivi du stock et des ventes
- Gestion du cycle de vie des commandes

### 🌐 Front-Office (Client)
- Consultation du catalogue
- Recherche et filtrage des produits
- Gestion du panier
- Passation et suivi des commandes

---

## 🧱 Architecture Technique

- **Framework** : Laravel (dernière version stable)
- **Architecture** : Monolithique MVC
- **Base de données** : MySQL
- **ORM** : Eloquent
- **Authentification** : Laravel Breeze / UI
- **Sécurité** : Middleware & Validation Laravel

---

## 👥 Rôles et Acteurs

| Rôle | Description |
|-----|-------------|
| Admin | Gère le catalogue, le stock et les commandes |
| Utilisateur | Consulte les produits et passe des commandes |

---

## 🗂️ Modélisation des Données

### Entités principales

#### User
- id
- name
- email (unique)
- password
- adresse
- telephone
- role (admin / client)

#### Category
- id
- name
- slug
- description

#### Supplier
- id
- name
- email (unique)
- city
- phone

#### Product (Soft Delete)
- id
- name
- reference (unique)
- description
- price
- stock
- image
- category_id
- supplier_id
- deleted_at

#### Order
- id
- user_id
- total_price
- status (En attente, Expédiée, Livrée, Annulée)

#### Order_Product (Pivot)
- order_id
- product_id
- quantity
- unit_price (figé lors de la commande)



## ⚙️ Fonctionnalités

### 🛠️ Back-Office (Admin)

* Authentification sécurisée
* CRUD Catégories
* CRUD Fournisseurs
* CRUD Produits
* Upload d’images produits
* Soft Delete des produits
* Gestion manuelle du stock
* Tableau de bord (stock critique)
* Gestion des commandes et statuts

---

### 🛍️ Front-Office (Client)

* Consultation des catégories
* Filtrage des produits par catégorie
* Recherche par nom
* Fiche produit détaillée
* Panier dynamique
* Validation de commande
* Historique des commandes
* Suivi du statut des commandes

---

## 📏 Règles Métier

* Un produit appartient obligatoirement à une catégorie et un fournisseur
* Le prix doit être un nombre positif
* Impossible d’ajouter au panier une quantité supérieure au stock
* Le prix est figé lors de la commande
* Le stock est décrémenté uniquement si la commande est validée
* Les produits supprimés (Soft Delete) restent liés aux commandes passées

---

## ✅ Contraintes de Validation

### Produits

```php
'price' => 'required|numeric|min:0',
'reference' => 'required|unique:products',
'image' => 'image|mimes:jpeg,png,jpg|max:2048',
```

### Utilisateurs & Fournisseurs

```php
'email' => 'required|email|unique:users',
```

---

## 🔐 Sécurité

* Accès `/admin` réservé aux administrateurs
* Middleware `admin`
* Protection CSRF
* Validation côté serveur

---

## 🔄 Transactions SQL (Commande)

```php
DB::transaction(function () {
    // Création de la commande
    // Association des produits avec prix figé
    // Mise à jour du stock
});
```

---

## 📁 Structure du Projet

```
app/
 ├── Models/
 ├── Http/
 │    ├── Controllers/Admin/
 │    └── Controllers/Front/
 ├── Middleware/
resources/
 ├── views/admin/
 └── views/front/
routes/
 ├── web.php
 └── admin.php
```

---

## 🚀 Installation

```bash
git clone https://github.com/votre-repo/tifawinsouk.git
cd tifawinsouk
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

---

## 📦 Livrables Pédagogiques Attendus

* Diagramme UML
* Migrations & Seeders
* CRUD fonctionnels
* Validation des formulaires
* Sécurité & Middleware
* Respect des règles métier

---

## 📝 Licence

Projet pédagogique – Formation Développeur Web & Web Mobile (2023)

```

---

Souhaitez-vous maintenant :
- 📄 une **version simplifiée pour étudiants**
- 🧩 un **diagramme UML**
- 🧪 des **Seeders Laravel**
- 🗃️ les **migrations complètes**

👉 Indiquez-moi la prochaine étape.
```

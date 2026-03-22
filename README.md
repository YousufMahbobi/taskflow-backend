# TaskFlow API

TaskFlow is a **minimal, backend-focused task management API** built with **Laravel 12**.  
It is designed as a **portfolio/demo project**, prioritizing clean architecture and core functionality over feature complexity.

> This repository contains **API only**.  
> Frontend (Vue 3 + Pinia SPA) is available here:  
> https://github.com/YousufMahbobi/taskflow-frontend.git

---

## Overview

The goal of TaskFlow is to demonstrate:

- Strong Laravel fundamentals  
- Clean RESTful API design  
- Authentication for SPA applications  
- Role-based access control  
- Practical database relationships  

This project focuses on delivering a **clean and maintainable backend** within a realistic scope.

---

## Core Features

- Authentication using **Laravel Sanctum (SPA-based)**
- User management
- User profile (**one-to-one relationship**)
- Task management:
  - A user can have **many tasks**
  - Each task belongs to **one user**
- Role & permission system using **Spatie Laravel Permission**
  - Roles: `admin`, `manager`, `user`
- Consistent and structured API responses

---

## Tech Stack

### Backend
- PHP 8.2+
- Laravel 12
- MySQL
- Laravel Sanctum
- Spatie Roles & Permissions

### Frontend (separate repository)
- Vue 3 (TypeScript)
- Pinia
- Vuetify (Materio Admin Template)

---

## Architecture Notes

- RESTful API design
- Clear separation of concerns
- SPA authentication using Sanctum cookies
- Role-based authorization via middleware and policies

---

## Installation and Configuration

### 1. Clone the repository
```bash
git clone https://github.com/YousufMahbobi/taskflow-backend.git
cd taskflow-backend
```

### 2. Install dependencies
```bash
composer install
```

### 3. Environment setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Update your .env file
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskflow
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Run migrations
```bash
php artisan migrate
```

6. **Set up public storage link**

To make uploaded files (like avatars) publicly accessible:

```bash
php artisan storage:link

### 7. Start development server
```bash
php artisan serve
```






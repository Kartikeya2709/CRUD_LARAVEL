# Laravel User Profile & Comment Management System
By Kartikeya Sharma


## Table of Contents
1. [Project Overview](#project-overview)
2. [System Architecture](#system-architecture)
3. [Setup Instructions](#setup-instructions)
4. [Database Structure](#database-structure)
5. [Data Flow & Process Diagrams](#data-flow--process-diagrams)
6. [API Documentation](#api-documentation)
7. [Performance Features](#performance-features)
8. [Troubleshooting](#troubleshooting)

## Project Overview
A high-performance Laravel application for managing user profiles and comments with features like caching, pagination, and audit logging. The system is designed to handle large datasets efficiently with optimized database queries and caching strategies.

### Key Features
- User profile management
- Comment system with audit logging
- Caching implementation
- Pagination
- Database transaction management
- Data integrity checks

## System Architecture

### Technology Stack
- PHP 8.x
- Laravel 10.x
- MySQL/MariaDB
- Laravel Cache 
- Blade Template
- Bootstrap 5

### Component Diagram
```
+----------------+      +----------------+      +----------------+
|   Web Browser  | ---> |  Laravel App   | ---> |    Database    |
+----------------+      +----------------+      +----------------+
                              |
                              |
                     +----------------+
                     |  Cache Layer   |
                     +----------------+
```

### Data Flow Diagrams

#### 1. User Profile Creation Flow
```
[Client Request] → [Validation] → [Transaction Begin] → [Create Profile]
       ↓                                                       ↓
 [Create Comment] → [Log Action] → [Transaction Commit] → [Cache Update]
```

#### 2. Comment Update Flow
```
[Update Request] → [Validation] → [Find Profile] → [Transaction Begin]
       ↓                                                ↓
[Update Comment] → [Create Log] → [Transaction Commit] → [Cache Clear]
```

#### 3. Data Retrieval Flow
```
[Page Request] → [Check Cache] → [Cache Hit?] → Yes → [Return Data]
                                     ↓
                                    No
                                     ↓
                            [Query Database] → [Store in Cache] → [Return Data]
```

## Setup Instructions

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL

### Installation Steps

1. Clone the repository:
```bash
git clone <repository-url>
cd CRUD
```

2. Install dependencies:
```bash
composer install
```

3. Set up environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in .env:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Run migrations:
```bash
php artisan migrate
```

6. Seed the database:
```bash
php artisan db:seed --class=UserProfileSeeder
php artisan db:seed --class=UserCommentSeeder
```

7. Start the development server:
```bash
php artisan serve
```

## Database Structure

### Entity Relationship Diagram
```
+---------------+       +---------------+       +---------------+
| UserProfile   |       | UserComment   |       | CommentLog    |
+---------------+       +---------------+       +---------------+
| email (PK)    |----1-|email (PK,FK)  |----1-|email (FK)     |
| name          |       |comment        |       |old_comment    |
| username      |       |created_at     |       |new_comment    |
| date_of_birth |       |updated_at     |       |action         |
| gender        |       +---------------+       |created_at     |
| phone         |                               |updated_at     |
| address       |                               +---------------+
| city          |
| state         |
| country       |
| zip           |
| created_at    |
| updated_at    |
+---------------+
```

## Performance Features

### 1. Caching Implementation
- Page-level caching with 5-minute duration
- Automatic cache invalidation on updates
- Cache tags for efficient cache management

### 2. Database Optimization
- Indexed queries
- Eager loading relationships
- Chunked data processing for large datasets

### 3. Transaction Management
- ACID compliance
- Automatic rollback on failures
- Audit logging for changes

## API Documentation

### User Profile Endpoints

#### Create User Profile
```http
POST /api/users
Content-Type: application/json

{
    "email": "user@example.com",
    "name": "John Doe",
    "comment": "Initial comment"
    // ... other fields
}
```

#### Update User Comment
```http
PUT /api/users/{email}/comment
Content-Type: application/json

{
    "comment": "Updated comment"
}
```

## Troubleshooting

### Common Issues

1. Cache Inconsistency
```bash
# Clear application cache
php artisan cache:clear

# Clear view cache
php artisan view:clear
```

2. Database Sync Issues
```bash
# Reset and reseed database
php artisan migrate:fresh --seed
```

### Performance Monitoring
- Laravel Telescope for debugging
- Cache hit/miss monitoring
- Query performance logging


### User Profile Endpoints
| Method | URI | Name | Description
|--------|-----|------|------------
GET | / | – | Redirects to /users   
GET | /users | users.index | List all user comments
POST | /users | users.store | Store a new user comment
PUT | /users/{id} | users.update | Update a user comment
PATCH | /users/{id} | users.update | Partial update (alias for PUT)
DELETE | /users/{id} | users.destroy | Delete a user comment
GET | /logs | logs.index | View logs/history

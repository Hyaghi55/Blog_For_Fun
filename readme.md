# Blog for Fun

**Blog for Fun** is a simple blog application built using pure PHP. It follows the **Model-View-Controller (MVC)** architecture, designed to separate concerns and provide an organized, scalable project structure. The project is aimed at learning and applying core PHP concepts while adhering to best practices in software design.

## Features

- User Registration and Login System
- Create, Edit, and Delete Blog Posts
- View Posts by All Users
- Basic Input Validation
- Simple Routing System
- Organized Views for Clean UI Rendering
- Follows MVC Architecture

## Project Structure

```plaintext
Blog-for-Fun/
│
├── app/
│   ├── Controllers/
│   │   └── UserController.php
│   │   └── PostController.php
│   └── Models/
│       └── User.php
│       └── Post.php
│
├── config/
│   └── database.php
│
├── public/
│   └── index.php
│
├── routes/
│   └── web.php
│
├── resources/
│   ├── views/
│   │   └── home.php
│   │   └── post.php
│   └── css/
│       └── style.css
│
├── Services/
│   └── Validation.php
│
└── Helpers/
    └── View.php

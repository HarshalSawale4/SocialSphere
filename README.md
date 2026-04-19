# SocialSphere – Full‑Stack Social Media Platform

SocialSphere is a **dynamic, multi‑user social network** built with PHP, MySQL, HTML/CSS, and vanilla JavaScript. It allows users to register, create posts with images, like/comment, send friend requests, chat privately in real time, and customize their profile – all without page reloads. The UI is fully responsive and inspired by modern social apps like Instagram.



## ✨ Features

- **User system** – Register, login, logout (password hashing).
- **Posts** – Text + optional image URL; feed shows posts from friends + self.
- **Likes & comments** – Real‑time toggle likes and add comments.
- **Friend system** – Send/accept friend requests; friends list.
- **Real‑time updates** – New posts, messages, and requests appear automatically (polling every 3‑5 seconds).
- **Private chat** – One‑on‑one messaging with friends.
- **Profile settings** – Change name, username, email, bio, avatar (image upload), and password.
- **Notifications** – Bell icon with badge count (unread messages + pending requests) + toast alerts.
- **Fully responsive** – Works on mobile, tablet, and desktop.
- **Modern UI** – Rounded cards, sticky sidebars, floating chat modal.

## 🛠️ Tech Stack

- **Backend:** PHP 7.4+ (no frameworks, PDO for DB)
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript (ES6)
- **AJAX:** Fetch API
- **Icons:** Font Awesome 6
- **Fonts:** Google Fonts (Inter)

## 📁 Project Structure
SocialSphere/
├── index.php # Main application (UI + JS)
├── config.php # Database connection & session
├── logout.php # Destroy session
├── api/ # Backend API endpoints
│ ├── register.php
│ ├── login.php
│ ├── get_feed.php
│ ├── create_post.php
│ ├── like_post.php
│ ├── add_comment.php
│ ├── send_friend_request.php
│ ├── accept_friend_request.php
│ ├── get_friends.php
│ ├── get_requests.php
│ ├── search_users.php
│ ├── get_messages.php
│ ├── send_message.php
│ ├── mark_messages_read.php
│ ├── get_unread_count.php
│ ├── update_profile.php
│ └── upload_avatar.php
├── uploads/ # User avatars (created automatically)
├── database.sql # MySQL schema
└── README.md



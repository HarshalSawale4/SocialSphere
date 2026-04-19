CREATE DATABASE socialsphere_db;
USE socialsphere_db;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT 'uploads/default-avatar.png',
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Posts table
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Likes table
CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_like (post_id, user_id)
);

-- Comments table
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Friend requests (status: 'pending', 'accepted')
CREATE TABLE friend_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    from_user INT NOT NULL,
    to_user INT NOT NULL,
    status ENUM('pending','accepted') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (from_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (to_user) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_request (from_user, to_user)
);

-- Messages table
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    from_user INT NOT NULL,
    to_user INT NOT NULL,
    content TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (from_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (to_user) REFERENCES users(id) ON DELETE CASCADE
);
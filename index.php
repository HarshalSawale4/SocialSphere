<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>SocialSphere – Connect & Share</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f0f2f5; }

        /* ----- Auth Modal ----- */
        .auth-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 16px;
        }
        .auth-card {
            background: white;
            width: 100%;
            max-width: 460px;
            border-radius: 28px;
            padding: 28px 20px;
        }
        .auth-tabs {
            display: flex;
            gap: 20px;
            border-bottom: 2px solid #e4e6eb;
            margin-bottom: 20px;
        }
        .auth-tab {
            font-size: 1.4rem;
            font-weight: 700;
            cursor: pointer;
            padding-bottom: 8px;
            color: #65676b;
        }
        .auth-tab.active {
            color: #1877f2;
            border-bottom: 3px solid #1877f2;
        }
        .auth-form {
            display: none;
            flex-direction: column;
            gap: 16px;
            margin-top: 20px;
        }
        .auth-form.active-form { display: flex; }
        .auth-form input {
            padding: 14px;
            border-radius: 16px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }
        .auth-btn {
            background: #1877f2;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
        }
        .error-msg { color: #e41e3f; font-size: 0.8rem; }

        /* ----- Navbar (mobile first) ----- */
        .navbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            background: white;
            padding: 10px 16px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 100;
            gap: 12px;
        }
        .nav-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #1877f2, #9b59b6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
        }
        .nav-user {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f0f2f5;
            padding: 4px 12px;
            border-radius: 40px;
        }
        .nav-user img { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }
        .nav-user span { font-size: 0.9rem; font-weight: 500; }
        .notification-icon {
            position: relative;
            cursor: pointer;
            font-size: 1.4rem;
            color: #1877f2;
        }
        .badge {
            position: absolute;
            top: -8px;
            right: -12px;
            background: #e41e3f;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.7rem;
            font-weight: bold;
        }
        #logoutBtn {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: #65676b;
        }

        /* ----- Container (mobile first) ----- */
        .container {
            display: flex;
            flex-direction: column;
            padding: 16px;
            gap: 16px;
        }
        .left-sidebar, .right-sidebar {
            background: white;
            border-radius: 24px;
            padding: 16px;
            width: 100%;
        }
        .left-sidebar { position: static; }
        .right-sidebar { position: static; }
        .main-content { width: 100%; }

        /* Story gallery */
        .story-gallery {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            scrollbar-width: thin;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }
        .story {
            flex: 0 0 90px;
            height: 160px;
            border-radius: 16px;
            background-size: cover;
            background-position: center;
            position: relative;
            cursor: pointer;
        }
        .story img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 3px solid #1877f2;
            position: absolute;
            top: 8px;
            left: 8px;
        }

        /* Write post */
        .write-post {
            background: white;
            border-radius: 24px;
            padding: 16px;
            margin-bottom: 20px;
        }
        .post-input-area {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }
        .post-input-area img { width: 40px; height: 40px; border-radius: 50%; }
        .post-input-area textarea {
            flex: 1;
            border: none;
            background: #f0f2f5;
            border-radius: 24px;
            padding: 12px 16px;
            resize: vertical;
            font-size: 0.9rem;
        }
        .post-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #eef2f6;
        }
        .post-actions input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 30px;
            border: 1px solid #ddd;
        }
        .post-actions button {
            background: #1877f2;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
        }

        /* Post card */
        .post-card {
            background: white;
            border-radius: 24px;
            padding: 16px;
            margin-bottom: 16px;
        }
        .post-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .post-user {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .post-user img { width: 44px; height: 44px; border-radius: 50%; }
        .post-img {
            width: 100%;
            border-radius: 20px;
            margin: 12px 0;
            max-height: 300px;
            object-fit: cover;
        }
        .post-stats {
            display: flex;
            gap: 20px;
            margin: 12px 0;
            color: #65676b;
            font-size: 0.9rem;
        }
        .like-btn, .comment-toggle { cursor: pointer; font-weight: 500; }

        /* Comments */
        .comments-section {
            margin-top: 12px;
            background: #f9fafb;
            padding: 12px;
            border-radius: 20px;
            display: none;
        }

        /* Friend items */
        .friend-item, .request-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
            flex-wrap: wrap;
            gap: 8px;
        }
        .friend-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .friend-info img { width: 38px; height: 38px; border-radius: 50%; }
        .small-btn {
            background: #1877f2;
            border: none;
            padding: 6px 12px;
            border-radius: 20px;
            color: white;
            font-size: 0.75rem;
            cursor: pointer;
        }

        /* Chat modal */
        .chat-modal {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            background: white;
            border-radius: 24px 24px 0 0;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.2);
            z-index: 300;
            display: none;
            flex-direction: column;
        }
        .chat-header {
            background: #1877f2;
            color: white;
            padding: 14px;
            display: flex;
            justify-content: space-between;
            border-radius: 24px 24px 0 0;
        }
        .chat-messages {
            height: 350px;
            overflow-y: auto;
            padding: 12px;
            background: #f7f9fc;
        }
        .chat-input-area {
            display: flex;
            padding: 12px;
            gap: 8px;
            border-top: 1px solid #ddd;
        }
        .chat-input-area input {
            flex: 1;
            padding: 10px;
            border-radius: 30px;
            border: 1px solid #ccc;
        }

        /* Toast */
        .toast {
            position: fixed;
            bottom: 20px;
            left: 16px;
            right: 16px;
            background: #333;
            color: white;
            padding: 12px 20px;
            border-radius: 30px;
            z-index: 1000;
            animation: fadeInOut 3s forwards;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            text-align: center;
        }
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(20px); }
            10% { opacity: 1; transform: translateY(0); }
            90% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(20px); visibility: hidden; }
        }

        /* Tablet and up */
        @media (min-width: 768px) {
            .container {
                flex-direction: row;
                padding: 24px 5%;
                gap: 24px;
            }
            .left-sidebar, .right-sidebar {
                position: sticky;
                top: 80px;
                align-self: start;
            }
            .left-sidebar { flex: 1.2; }
            .main-content { flex: 2.5; }
            .right-sidebar { flex: 1.4; }
            .navbar { padding: 10px 5%; flex-wrap: nowrap; }
            .post-actions {
                flex-direction: row;
                align-items: center;
            }
            .post-actions input { width: auto; }
            .chat-modal {
                bottom: 20px;
                right: 20px;
                left: auto;
                width: 360px;
                border-radius: 24px;
            }
            .chat-header { border-radius: 24px 24px 0 0; }
            .toast { left: 20px; right: auto; }
        }

        /* Small phone adjustments */
        @media (max-width: 480px) {
            .logo { font-size: 1.3rem; }
            .nav-user span { display: none; }
            .nav-user { padding: 4px 8px; }
            .story { flex: 0 0 75px; height: 140px; }
            .post-user img { width: 36px; height: 36px; }
            .post-card { padding: 12px; }
            .auth-card { padding: 20px; }
        }
        /* Settings Modal */
.settings-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(4px);
    z-index: 1001;
    justify-content: center;
    align-items: center;
}
.settings-modal-content {
    background: white;
    width: 90%;
    max-width: 500px;
    max-height: 85vh;
    overflow-y: auto;
    border-radius: 28px;
    padding: 24px;
    position: relative;
    animation: slideUp 0.2s ease;
}
@keyframes slideUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
.settings-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 1px solid #eef2f6;
}
.close-settings {
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    color: #65676b;
}
.avatar-upload {
    text-align: center;
    margin-bottom: 20px;
}
.avatar-upload img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #1877f2;
    margin-bottom: 10px;
}
.upload-btn {
    display: inline-block;
    background: #1877f2;
    color: white;
    padding: 8px 16px;
    border-radius: 30px;
    cursor: pointer;
    font-size: 0.85rem;
}
#avatarUpload {
    display: none;
}
.settings-field {
    margin-bottom: 16px;
}
.settings-field label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    color: #333;
}
.settings-field input, .settings-field textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 16px;
    font-size: 0.95rem;
}
.settings-message {
    margin: 12px 0;
    font-size: 0.85rem;
    text-align: center;
}
.save-settings-btn {
    width: 100%;
    background: #1877f2;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 40px;
    font-weight: 600;
    cursor: pointer;
}
    </style>
</head>
<body>

<?php if (!isLoggedIn()): ?>
<div id="authOverlay" class="auth-overlay">
    <div class="auth-card">
        <div class="auth-tabs">
            <div class="auth-tab active" data-tab="login">Log In</div>
            <div class="auth-tab" data-tab="register">Sign Up</div>
        </div>
        <div id="loginForm" class="auth-form active-form">
            <input type="text" id="loginEmail" placeholder="Email or Username">
            <input type="password" id="loginPassword" placeholder="Password">
            <div id="loginError" class="error-msg"></div>
            <button class="auth-btn" id="doLogin">Login</button>
        </div>
        <div id="registerForm" class="auth-form">
            <input type="text" id="regFullname" placeholder="Full Name">
            <input type="text" id="regUsername" placeholder="Username">
            <input type="email" id="regEmail" placeholder="Email">
            <input type="password" id="regPassword" placeholder="Password">
            <div id="regError" class="error-msg"></div>
            <button class="auth-btn" id="doRegister">Create Account</button>
        </div>
    </div>
</div>
<?php else: 
    $user = getUserById($pdo, $_SESSION['user_id']);
?>
<script>window.currentUser = <?= json_encode($user) ?>;</script>
<?php endif; ?>

<div id="appContainer" style="<?= isLoggedIn() ? 'display:block' : 'display:none' ?>">
    <nav class="navbar">
        <div class="nav-left">
            <h2 class="logo">SocialSphere</h2>
            <div class="notification-icon" id="notificationBell">
                <i class="fa-regular fa-bell"></i>
                <span id="notificationBadge" class="badge">0</span>
            </div>
        </div>
        <div class="nav-right">
            <div class="nav-user">
                <img id="navAvatar" src="">
                <span id="navName"></span>
            </div>
            <button id="logoutBtn"><i class="fas fa-sign-out-alt"></i></button>
        </div>
    </nav>

    <div class="container">
        <aside class="left-sidebar">
            <div class="profile-card" style="text-align:center">
                <img id="sidebarAvatar" style="width:80px;height:80px;border-radius:50%;border:3px solid #1877f2">
                <h3 id="sidebarName"></h3>
                <p id="sidebarBio"></p>
                <div style="display:flex; justify-content:space-around; margin-top:12px;">
                    <div><strong id="friendCount">0</strong><br>Friends</div>
                    <div><strong id="postCount">0</strong><br>Posts</div>
                </div>
            </div>
            <div style="margin-top:20px">
    <a href="#" id="myFeedBtn" style="display:flex; gap:12px; margin-bottom:16px;"><i class="fas fa-rss"></i> My Feed</a>
    <a href="#" id="findPeopleBtn" style="display:flex; gap:12px; margin-bottom:16px;"><i class="fas fa-user-plus"></i> Discover People</a>
    <a href="#" id="settingsBtn" style="display:flex; gap:12px;"><i class="fas fa-cog"></i> Settings</a>
</div>
        </aside>

        <main class="main-content">
            <div class="story-gallery" id="storyGallery"></div>
            <div class="write-post">
                <div class="post-input-area">
                    <img id="currentUserPostAvatar" src="">
                    <textarea id="postContent" rows="2" placeholder="What's on your mind?"></textarea>
                </div>
                <div class="post-actions">
                    <input type="text" id="postImageUrl" placeholder="Image URL (optional)">
                    <button id="createPostBtn">Post</button>
                </div>
            </div>
            <div id="feedContainer"></div>
        </main>

        <aside class="right-sidebar">
            <div class="sidebar-title"><h4>📨 Friend Requests</h4></div>
            <div id="requestsList">Loading...</div>
            <div class="sidebar-title" style="margin-top:20px"><h4>👥 Your Friends</h4></div>
            <div id="friendsListContainer">Loading...</div>
            <div class="sidebar-title" style="margin-top:20px"><h4>🔍 Discover People</h4></div>
            <div id="discoverPeopleList"></div>
        </aside>
    </div>
</div>

<div id="chatModal" class="chat-modal">
    <div class="chat-header">
        <span id="chatFriendName">Chat</span>
        <button id="closeChatBtn" style="background:none; border:none; color:white; font-size:1.5rem;">&times;</button>
    </div>
    <div class="chat-messages" id="chatMessagesBox"></div>
    <div class="chat-input-area">
        <input id="chatInput" placeholder="Type a message...">
        <button id="sendMsgBtn" style="background:#1877f2; border:none; border-radius:30px; padding:0 16px; color:white;">Send</button>
    </div>
</div>

<!-- Settings Modal -->
<div id="settingsModal" class="settings-modal">
    <div class="settings-modal-content">
        <div class="settings-header">
            <h3><i class="fas fa-cog"></i> Account Settings</h3>
            <span class="close-settings">&times;</span>
        </div>
        <form id="settingsForm" enctype="multipart/form-data">
            <div class="avatar-upload">
                <img id="settingsAvatarPreview" src="" alt="Avatar">
                <label for="avatarUpload" class="upload-btn"><i class="fas fa-camera"></i> Change Photo</label>
                <input type="file" id="avatarUpload" accept="image/jpeg,image/png,image/jpg">
            </div>
            <div class="settings-field">
                <label>Full Name</label>
                <input type="text" id="settingsFullname" placeholder="Full Name">
            </div>
            <div class="settings-field">
                <label>Username</label>
                <input type="text" id="settingsUsername" placeholder="Username">
            </div>
            <div class="settings-field">
                <label>Email</label>
                <input type="email" id="settingsEmail" placeholder="Email">
            </div>
            <div class="settings-field">
                <label>Bio</label>
                <textarea id="settingsBio" rows="3" placeholder="Tell something about yourself..."></textarea>
            </div>
            <div class="settings-field">
                <label>New Password (leave blank to keep current)</label>
                <input type="password" id="settingsPassword" placeholder="New password">
            </div>
            <div id="settingsMessage" class="settings-message"></div>
            <button type="submit" class="save-settings-btn">Save Changes</button>
        </form>
    </div>
</div>

<script>
const API_BASE = 'api/';
let currentUser = window.currentUser || null;
let activeChatUser = null;
let lastPostTime = 0, lastRequestCount = 0, lastMessageCount = 0, pollInterval;

// Tab switching
const loginTab = document.querySelector('.auth-tab[data-tab="login"]');
const registerTab = document.querySelector('.auth-tab[data-tab="register"]');
const loginFormDiv = document.getElementById('loginForm');
const registerFormDiv = document.getElementById('registerForm');
if (loginTab && registerTab) {
    loginTab.addEventListener('click', () => {
        loginTab.classList.add('active');
        registerTab.classList.remove('active');
        loginFormDiv.classList.add('active-form');
        registerFormDiv.classList.remove('active-form');
    });
    registerTab.addEventListener('click', () => {
        registerTab.classList.add('active');
        loginTab.classList.remove('active');
        registerFormDiv.classList.add('active-form');
        loginFormDiv.classList.remove('active-form');
    });
}



async function apiCall(endpoint, data = null) {
    const options = { method: data ? 'POST' : 'GET', headers: { 'Content-Type': 'application/json' } };
    if (data) options.body = JSON.stringify(data);
    const res = await fetch(API_BASE + endpoint, options);
    return res.json();
}

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `<i class="fa-${type === 'request' ? 'solid fa-user-plus' : 'solid fa-envelope'}"></i> ${message}`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

function attachPostEvents() {
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.onclick = async () => {
            await apiCall('like_post.php', { post_id: btn.getAttribute('data-id') });
            loadFeed();
        };
    });
    document.querySelectorAll('.comment-toggle').forEach(btn => {
        btn.onclick = () => {
            const div = document.getElementById(`comments-${btn.getAttribute('data-id')}`);
            if (div) div.style.display = div.style.display === 'none' ? 'block' : 'none';
        };
    });
}

function renderFeed(posts) {
    const container = document.getElementById('feedContainer');
    if (!posts.length) { container.innerHTML = '<div class="post-card">No posts from friends yet. Start connecting!</div>'; return; }
    container.innerHTML = posts.map(post => `
        <div class="post-card" data-post-id="${post.id}">
            <div class="post-header">
                <div class="post-user">
                    <img src="${post.avatar || 'uploads/default-avatar.png'}">
                    <div><strong>${post.fullname}</strong><br><small>${new Date(post.created_at).toLocaleString()}</small></div>
                </div>
            </div>
            <div>${post.content.replace(/\n/g, '<br>')}</div>
            ${post.image_url ? `<img class="post-img" src="${post.image_url}" onerror="this.style.display='none'">` : ''}
            <div class="post-stats">
                <span class="like-btn" data-id="${post.id}"><i class="fa-${post.liked_by_user ? 'solid' : 'regular'} fa-heart" style="color:${post.liked_by_user ? '#e41e3f' : '#65676b'}"></i> ${post.likes_count} likes</span>
                <span class="comment-toggle" data-id="${post.id}"><i class="fa-regular fa-comment"></i> ${post.comments.length} comments</span>
            </div>
            <div class="comments-section" id="comments-${post.id}">
                <div id="comment-list-${post.id}">${post.comments.map(c => `<div><strong>${c.fullname}:</strong> ${c.content}</div>`).join('')}</div>
                <div style="display:flex; gap:8px; margin-top:8px;"><input type="text" id="commentInput-${post.id}" placeholder="Write a comment..." style="flex:1; border-radius:20px; border:1px solid #ddd; padding:6px;"><button class="small-btn" onclick="addComment('${post.id}')">Post</button></div>
            </div>
        </div>
    `).join('');
    attachPostEvents();
}

window.addComment = async function(postId) {
    const input = document.getElementById(`commentInput-${postId}`);
    if (!input.value.trim()) return;
    await apiCall('add_comment.php', { post_id: postId, content: input.value });
    input.value = '';
    loadFeed();
    loadSidebarData();
};

async function loadFeed() {
    if (!currentUser) return;
    const data = await apiCall('get_feed.php');
    renderFeed(data.posts);
}

async function loadSidebarData() {
    if (!currentUser) return;
    const requests = await apiCall('get_requests.php');
    const requestsDiv = document.getElementById('requestsList');
    if (requests.length === 0) requestsDiv.innerHTML = '<div>✨ No pending requests</div>';
    else {
        requestsDiv.innerHTML = requests.map(req => `
            <div class="request-item">
                <div class="friend-info"><img src="${req.avatar}"><span>${req.fullname}</span></div>
                <button class="small-btn accept-req" data-id="${req.id}">Accept</button>
            </div>
        `).join('');
        document.querySelectorAll('.accept-req').forEach(btn => {
            btn.onclick = async () => {
                await apiCall('accept_friend_request.php', { request_id: btn.getAttribute('data-id') });
                loadSidebarData();
                loadFeed();
                updateProfileStats();
            };
        });
    }
    const friends = await apiCall('get_friends.php');
    const friendsDiv = document.getElementById('friendsListContainer');
    if (friends.length === 0) friendsDiv.innerHTML = '<div>🤝 No friends yet. Send requests!</div>';
    else {
        friendsDiv.innerHTML = friends.map(f => `
            <div class="friend-item">
                <div class="friend-info"><img src="${f.avatar}"><span>${f.fullname}</span></div>
                <button class="small-btn chat-start" data-id="${f.id}" data-name="${f.fullname}" data-avatar="${f.avatar}">Message</button>
            </div>
        `).join('');
        document.querySelectorAll('.chat-start').forEach(btn => {
            btn.onclick = () => openChat(btn.getAttribute('data-id'), btn.getAttribute('data-name'), btn.getAttribute('data-avatar'));
        });
    }
    const discover = await apiCall('search_users.php');
    const discoverDiv = document.getElementById('discoverPeopleList');
    if (discover.length === 0) discoverDiv.innerHTML = '<div>🌟 All caught up!</div>';
    else {
        discoverDiv.innerHTML = discover.map(u => `
            <div class="friend-item">
                <div class="friend-info"><img src="${u.avatar}"><span>${u.fullname}</span></div>
                <button class="small-btn send-req" data-id="${u.id}">Connect</button>
            </div>
        `).join('');
        document.querySelectorAll('.send-req').forEach(btn => {
            btn.onclick = async () => {
                await apiCall('send_friend_request.php', { to_user: btn.getAttribute('data-id') });
                loadSidebarData();
            };
        });
    }
}

async function updateProfileStats() {
    if (!currentUser) return;
    const friends = await apiCall('get_friends.php');
    const posts = await apiCall('get_feed.php');
    const myPosts = posts.posts.filter(p => p.user_id == currentUser.id).length;
    document.getElementById('friendCount').innerText = friends.length;
    document.getElementById('postCount').innerText = myPosts;
}

async function openChat(userId, name, avatar) {
    activeChatUser = { id: userId, fullname: name, avatar };
    await apiCall('mark_messages_read.php', { with_user: userId });
    document.getElementById('chatFriendName').innerHTML = `<img src="${avatar}" style="width:28px;border-radius:50%;margin-right:8px;"> ${name}`;
    document.getElementById('chatModal').style.display = 'flex';
    await loadMessages();
}

async function loadMessages() {
    if (!currentUser || !activeChatUser) return;
    const data = await apiCall('get_messages.php', { with_user: activeChatUser.id });
    const box = document.getElementById('chatMessagesBox');
    box.innerHTML = data.messages.map(m => {
        const isMe = m.from_user == currentUser.id;
        return `<div style="text-align:${isMe?'right':'left'}; margin:8px 0;"><span style="background:${isMe?'#1877f2':'#e4e6eb'}; color:${isMe?'white':'black'}; padding:8px 12px; border-radius:20px; display:inline-block;">${m.content}</span><br><small>${new Date(m.created_at).toLocaleTimeString()}</small></div>`;
    }).join('');
    box.scrollTop = box.scrollHeight;
}

async function sendMessage() {
    const input = document.getElementById('chatInput');
    if (!input.value.trim() || !activeChatUser) return;
    await apiCall('send_message.php', { to_user: activeChatUser.id, content: input.value });
    input.value = '';
    loadMessages();
}

async function fetchNotificationCounts() {
    if (!currentUser) return { requests: 0, unreadMessages: 0 };
    const requests = await apiCall('get_requests.php');
    const unread = await apiCall('get_unread_count.php');
    return { requests: requests.length, unreadMessages: unread.count || 0 };
}

function updateNotificationBadge(total) {
    const badge = document.getElementById('notificationBadge');
    if (badge) {
        badge.innerText = total;
        badge.style.display = total > 0 ? 'inline-block' : 'none';
    }
}

async function pollNotifications() {
    const counts = await fetchNotificationCounts();
    const total = counts.requests + counts.unreadMessages;
    updateNotificationBadge(total);
    if (counts.requests > lastRequestCount) {
        showToast(`${counts.requests - lastRequestCount} new friend request(s)!`, 'request');
        loadSidebarData();
    }
    if (counts.unreadMessages > lastMessageCount) {
        showToast(`${counts.unreadMessages - lastMessageCount} new message(s)`, 'message');
        loadSidebarData();
    }
    lastRequestCount = counts.requests;
    lastMessageCount = counts.unreadMessages;
}
// ---------- SETTINGS MODAL ----------
const settingsModal = document.getElementById('settingsModal');
const settingsBtn = document.getElementById('settingsBtn');
const closeSettings = document.querySelector('.close-settings');
const settingsForm = document.getElementById('settingsForm');
const avatarUpload = document.getElementById('avatarUpload');
const settingsAvatarPreview = document.getElementById('settingsAvatarPreview');

// Open modal
settingsBtn?.addEventListener('click', (e) => {
    e.preventDefault();
    // Load current user data into form
    document.getElementById('settingsFullname').value = currentUser.fullname || '';
    document.getElementById('settingsUsername').value = currentUser.username || '';
    document.getElementById('settingsEmail').value = currentUser.email || '';
    document.getElementById('settingsBio').value = currentUser.bio || '';
    settingsAvatarPreview.src = currentUser.avatar || 'uploads/default-avatar.png';
    document.getElementById('settingsPassword').value = '';
    document.getElementById('settingsMessage').innerHTML = '';
    settingsModal.style.display = 'flex';
});

closeSettings?.addEventListener('click', () => {
    settingsModal.style.display = 'none';
});

window.addEventListener('click', (e) => {
    if (e.target === settingsModal) settingsModal.style.display = 'none';
});

// Avatar upload preview and submit
avatarUpload?.addEventListener('change', async (e) => {
    const file = e.target.files[0];
    if (!file) return;
    const formData = new FormData();
    formData.append('avatar', file);
    const res = await fetch(API_BASE + 'upload_avatar.php', {
        method: 'POST',
        body: formData
    });
    const data = await res.json();
    if (data.success) {
        // Update preview and global currentUser
        settingsAvatarPreview.src = data.avatar + '?t=' + Date.now();
        currentUser.avatar = data.avatar;
        // Update sidebar and navbar avatars
        document.getElementById('sidebarAvatar').src = data.avatar;
        document.getElementById('navAvatar').src = data.avatar;
        document.getElementById('currentUserPostAvatar').src = data.avatar;
        showToast('Avatar updated!', 'info');
    } else {
        document.getElementById('settingsMessage').innerHTML = `<span style="color:red;">${data.error}</span>`;
    }
});

// Save profile changes
settingsForm?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const fullname = document.getElementById('settingsFullname').value;
    const username = document.getElementById('settingsUsername').value;
    const email = document.getElementById('settingsEmail').value;
    const bio = document.getElementById('settingsBio').value;
    const password = document.getElementById('settingsPassword').value;
    const data = await apiCall('update_profile.php', { fullname, username, email, bio, password });
    if (data.success) {
        // Update global currentUser
        currentUser = data.user;
        // Update UI
        document.getElementById('sidebarName').innerText = currentUser.fullname;
        document.getElementById('navName').innerText = currentUser.fullname.split(' ')[0];
        document.getElementById('sidebarBio').innerText = currentUser.bio || '✨ New on SocialSphere';
        document.getElementById('settingsMessage').innerHTML = '<span style="color:green;">Profile updated successfully!</span>';
        showToast('Profile updated', 'info');
        // Optionally refresh feed to show new name on posts
        loadFeed();
        setTimeout(() => settingsModal.style.display = 'none', 1500);
    } else {
        document.getElementById('settingsMessage').innerHTML = `<span style="color:red;">${data.error}</span>`;
    }
});

// Event listeners
document.getElementById('createPostBtn')?.addEventListener('click', async () => {
    const content = document.getElementById('postContent').value;
    const imageUrl = document.getElementById('postImageUrl').value;
    if (!content.trim() && !imageUrl.trim()) return;
    await apiCall('create_post.php', { content, image_url: imageUrl });
    document.getElementById('postContent').value = '';
    document.getElementById('postImageUrl').value = '';
    loadFeed();
    updateProfileStats();
});

document.getElementById('doLogin')?.addEventListener('click', async () => {
    const login = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;
    const data = await apiCall('login.php', { login, password });
    if (data.success) location.reload();
    else document.getElementById('loginError').innerText = data.error;
});

document.getElementById('doRegister')?.addEventListener('click', async () => {
    const fullname = document.getElementById('regFullname').value;
    const username = document.getElementById('regUsername').value;
    const email = document.getElementById('regEmail').value;
    const password = document.getElementById('regPassword').value;
    const data = await apiCall('register.php', { fullname, username, email, password });
    if (data.success) location.reload();
    else document.getElementById('regError').innerText = data.error;
});

document.getElementById('logoutBtn')?.addEventListener('click', () => window.location.href = 'logout.php');
document.getElementById('closeChatBtn')?.addEventListener('click', () => {
    document.getElementById('chatModal').style.display = 'none';
    activeChatUser = null;
});
document.getElementById('sendMsgBtn')?.addEventListener('click', sendMessage);
document.getElementById('chatInput')?.addEventListener('keypress', (e) => { if(e.key === 'Enter') sendMessage(); });
document.getElementById('myFeedBtn')?.addEventListener('click', (e) => { e.preventDefault(); loadFeed(); });
document.getElementById('findPeopleBtn')?.addEventListener('click', (e) => { e.preventDefault(); loadSidebarData(); });

// Initial load
if (currentUser) {
    document.getElementById('navAvatar').src = currentUser.avatar || 'uploads/default-avatar.png';
    document.getElementById('navName').innerText = currentUser.fullname.split(' ')[0];
    document.getElementById('sidebarAvatar').src = currentUser.avatar || 'uploads/default-avatar.png';
    document.getElementById('sidebarName').innerText = currentUser.fullname;
    document.getElementById('sidebarBio').innerText = currentUser.bio || '✨ New on SocialSphere';
    document.getElementById('currentUserPostAvatar').src = currentUser.avatar || 'uploads/default-avatar.png';
    loadFeed();
    loadSidebarData();
    updateProfileStats();
    pollNotifications();
    setInterval(pollNotifications, 5000);
    setInterval(() => { if(activeChatUser) loadMessages(); }, 3000);
}
</script>
</body>
</html>
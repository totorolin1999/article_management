<script setup>
import { RouterLink, RouterView, useRoute } from "vue-router";
const route = useRoute();

const isActive = (path) => {
  if (path === '/') return route.path === '/';
  return route.path.startsWith(path);
};
</script>

<template>
  <!-- 導航列 -->
  <header class="sticky-top">
    <nav class="navbar navbar-expand-lg app-navbar shadow-sm">
      <div class="container">
        <RouterLink class="navbar-brand d-flex align-items-center gap-2" to="/">
          <div class="brand-logo-icon">
            <i class="bi bi-journal-bookmark-fill text-white"></i>
          </div>
          <div class="d-flex flex-column">
            <span class="brand-title">文章管理系統</span>
            <span class="brand-subtitle">Article Management</span>
          </div>
        </RouterLink>

        <button
          class="navbar-toggler border-0 shadow-none"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navmenu"
          aria-controls="navmenu"
          aria-expanded="false"
          aria-label="切換選單"
        >
          <i class="bi bi-list fs-2 text-dark"></i>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
          <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1 my-2 my-lg-0">
            <li class="nav-item">
              <RouterLink
                class="nav-link nav-link-custom"
                :class="{ active: isActive('/') }"
                to="/"
              >
                <i class="bi bi-house-door me-1"></i>
                首頁
              </RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink
                class="nav-link nav-link-custom"
                :class="{ active: isActive('/articles') }"
                to="/articles"
              >
                <i class="bi bi-file-earmark-text me-1"></i>
                所有文章
              </RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink
                class="nav-link nav-link-custom"
                :class="{ active: isActive('/categories') }"
                to="/categories"
              >
                <i class="bi bi-folder2-open me-1"></i>
                文章分類
              </RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink
                class="nav-link nav-link-custom"
                :class="{ active: isActive('/tags') }"
                to="/tags"
              >
                <i class="bi bi-tags me-1"></i>
                文章標籤
              </RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink
                class="nav-link nav-link-custom"
                :class="{ active: isActive('/about') }"
                to="/about"
              >
                <i class="bi bi-info-circle me-1"></i>
                關於系統
              </RouterLink>
            </li>
            <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
              <RouterLink to="/articles/create" class="btn btn-primary btn-sm px-3 shadow-sm">
                <i class="bi bi-plus-lg"></i>
                <span>發布文章</span>
              </RouterLink>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- 主內容視圖 -->
  <main class="app-main">
    <RouterView />
  </main>

  <!-- 系統頁尾 -->
  <footer class="app-footer mt-auto py-4">
    <div class="container">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-layers-half text-primary fs-5"></i>
          <span class="text-secondary small">
            Laravel 10 API & Vue 3 SPA 文章管理系統
          </span>
        </div>
        <div class="d-flex align-items-center gap-3 text-secondary small">
          <span><i class="bi bi-check2-circle text-success me-1"></i>系統運行正常</span>
          <span class="text-muted">•</span>
          <span>前端版本 v1.1.0</span>
        </div>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.app-navbar {
  background: rgba(255, 255, 255, 0.92);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  border-bottom: 1px solid rgba(226, 232, 240, 0.8);
  padding-top: 0.75rem;
  padding-bottom: 0.75rem;
  transition: all 0.3s ease;
}

.brand-logo-icon {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  background: linear-gradient(135deg, #2563eb, #3b82f6);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.15rem;
  box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
}

.brand-title {
  font-size: 1.1rem;
  font-weight: 700;
  color: #0f172a;
  line-height: 1.2;
}

.brand-subtitle {
  font-size: 0.75rem;
  color: #64748b;
  font-weight: 500;
  letter-spacing: 0.04em;
}

.nav-link-custom {
  color: #475569;
  font-weight: 500;
  padding: 0.5rem 0.85rem !important;
  border-radius: 0.5rem;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
}

.nav-link-custom:hover {
  color: #2563eb;
  background-color: #f1f5f9;
}

.nav-link-custom.active {
  color: #2563eb;
  background-color: #eff6ff;
  font-weight: 600;
}

.app-footer {
  background-color: #ffffff;
  border-top: 1px solid #e2e8f0;
}
</style>

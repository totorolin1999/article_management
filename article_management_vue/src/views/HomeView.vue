<template>
  <div class="container my-5">
    <!-- Hero Banner -->
    <div class="hero-card mb-5 p-5 text-center text-md-start position-relative overflow-hidden">
      <div class="row align-items-center position-relative" style="z-index: 2;">
        <div class="col-lg-8">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-3 rounded-pill badge-hero">
            <span class="badge-dot"></span>
            <span>RESTful API + Vue 3 SPA 架構</span>
          </div>
          <h1 class="display-5 fw-bold text-dark tracking-tight mb-3">
            現代化 <span class="text-gradient">文章管理系統</span>
          </h1>
          <p class="fs-5 text-muted mb-4 pe-lg-4" style="line-height: 1.6;">
            極簡直覺的內容管理解決方案，整合 Laravel 10 後端服務與 Vue 3 單頁應用。支援完整文章 CRUD、分類階層化與多標籤彈性關聯。
          </p>
          <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-md-start">
            <RouterLink to="/articles" class="btn btn-primary btn-lg shadow-sm">
              <i class="bi bi-grid-3x3-gap-fill"></i>
              進入文章列表
            </RouterLink>
            <RouterLink to="/articles/create" class="btn btn-outline-secondary btn-lg bg-white">
              <i class="bi bi-pencil-square"></i>
              立即發布文章
            </RouterLink>
          </div>
        </div>
        <div class="col-lg-4 d-none d-lg-block text-center">
          <div class="hero-illustration">
            <i class="bi bi-layout-text-window-reverse hero-icon"></i>
          </div>
        </div>
      </div>
      <!-- 背景光暈裝飾 -->
      <div class="hero-glow hero-glow-1"></div>
      <div class="hero-glow hero-glow-2"></div>
    </div>

    <!-- 系統指標總覽 -->
    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="stat-card card-modern p-4">
          <div class="stat-icon bg-primary-subtle text-primary">
            <i class="bi bi-file-earmark-richtext-fill"></i>
          </div>
          <div>
            <div class="text-muted small fw-semibold text-uppercase">文章總量</div>
            <h3 class="fw-bold mb-0 text-dark">{{ articleCount }}</h3>
            <span class="text-muted small">支援分頁與關鍵字過濾</span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card card-modern p-4">
          <div class="stat-icon bg-success-subtle text-success">
            <i class="bi bi-folder-fill"></i>
          </div>
          <div>
            <div class="text-muted small fw-semibold text-uppercase">分類項目</div>
            <h3 class="fw-bold mb-0 text-dark">{{ categoryCount }}</h3>
            <span class="text-muted small">文章主題分類歸納</span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card card-modern p-4">
          <div class="stat-icon bg-info-subtle text-info">
            <i class="bi bi-tags-fill"></i>
          </div>
          <div>
            <div class="text-muted small fw-semibold text-uppercase">標籤總數</div>
            <h3 class="fw-bold mb-0 text-dark">{{ tagCount }}</h3>
            <span class="text-muted small">多對多自由組合標註</span>
          </div>
        </div>
      </div>
    </div>

    <!-- 核心功能模組 -->
    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="card h-100 card-modern border-0">
          <div class="card-body p-4 d-flex flex-column">
            <div class="feature-icon-wrapper mb-3 text-primary bg-primary-subtle">
              <i class="bi bi-newspaper fs-3"></i>
            </div>
            <h4 class="card-title fw-bold text-dark">文章管理模組</h4>
            <p class="card-text text-muted flex-grow-1">
              提供直覺分頁、即時搜尋過濾、外部連結跳轉，支援一鍵刪除與 SweetAlert2 二次防誤觸確認。
            </p>
            <div class="pt-3 border-top">
              <RouterLink to="/articles" class="btn btn-primary w-100">
                <i class="bi bi-arrow-right-circle"></i>
                管理所有文章
              </RouterLink>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 card-modern border-0">
          <div class="card-body p-4 d-flex flex-column">
            <div class="feature-icon-wrapper mb-3 text-success bg-success-subtle">
              <i class="bi bi-folder-check fs-3"></i>
            </div>
            <h4 class="card-title fw-bold text-dark">分類目錄模組</h4>
            <p class="card-text text-muted flex-grow-1">
              統一維護文章所屬類別，建立清晰的內容資訊架構，便於將文章快速歸檔與主題式檢閱。
            </p>
            <div class="pt-3 border-top">
              <RouterLink to="/categories" class="btn btn-success text-white w-100">
                <i class="bi bi-arrow-right-circle"></i>
                進入分類管理
              </RouterLink>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 card-modern border-0">
          <div class="card-body p-4 d-flex flex-column">
            <div class="feature-icon-wrapper mb-3 text-info bg-info-subtle">
              <i class="bi bi-tag-fill fs-3"></i>
            </div>
            <h4 class="card-title fw-bold text-dark">關鍵標籤模組</h4>
            <p class="card-text text-muted flex-grow-1">
              靈活建立關鍵字標籤，文章可多選綁定標籤，提升跨領域主題的內容關聯度與探索性。
            </p>
            <div class="pt-3 border-top">
              <RouterLink to="/tags" class="btn btn-info text-white w-100">
                <i class="bi bi-arrow-right-circle"></i>
                進入標籤管理
              </RouterLink>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from "@/services/api";

export default {
  name: "HomeView",
  data() {
    return {
      articleCount: "--",
      categoryCount: "--",
      tagCount: "--",
    };
  },
  mounted() {
    this.fetchOverview();
  },
  methods: {
    async fetchOverview() {
      try {
        const [artRes, catRes, tagRes] = await Promise.allSettled([
          api.get("/articles?page=1"),
          api.get("/categories"),
          api.get("/tags"),
        ]);

        if (artRes.status === "fulfilled") {
          this.articleCount = artRes.value.data?.paginate?.total || artRes.value.data?.paginate?.data?.length || 0;
        }
        if (catRes.status === "fulfilled") {
          this.categoryCount = catRes.value.data?.categories?.length || 0;
        }
        if (tagRes.status === "fulfilled") {
          this.tagCount = tagRes.value.data?.tags?.length || 0;
        }
      } catch (e) {
        console.error("載入概覽統計失敗", e);
      }
    },
  },
};
</script>

<style scoped>
.hero-card {
  background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
  border-radius: 1.5rem;
  border: 1px solid #e2e8f0;
  box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.05);
}

.text-gradient {
  background: linear-gradient(135deg, #2563eb, #1d4ed8);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.badge-hero {
  background-color: #eff6ff;
  color: #1d4ed8;
  font-size: 0.85rem;
  font-weight: 600;
  border: 1px solid #bfdbfe;
}

.badge-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background-color: #2563eb;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% { transform: scale(0.95); opacity: 0.8; }
  50% { transform: scale(1.3); opacity: 1; }
  100% { transform: scale(0.95); opacity: 0.8; }
}

.hero-illustration {
  position: relative;
  display: inline-block;
  color: #3b82f6;
  opacity: 0.85;
  filter: drop-shadow(0 15px 25px rgba(59, 130, 246, 0.25));
}

.hero-icon {
  font-size: 8rem;
}

.hero-glow {
  position: absolute;
  width: 300px;
  height: 300px;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.18;
  pointer-events: none;
}

.hero-glow-1 {
  background: #3b82f6;
  top: -80px;
  right: -50px;
}

.hero-glow-2 {
  background: #60a5fa;
  bottom: -100px;
  left: 20%;
}

.feature-icon-wrapper {
  width: 54px;
  height: 54px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>

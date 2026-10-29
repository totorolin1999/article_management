<template>
  <div class="container my-5">
    <div class="p-5 mb-4 bg-light rounded-3 shadow-sm text-center">
      <div class="container-fluid py-3">
        <h1 class="display-5 fw-bold text-primary">文章管理系統</h1>
        <p class="col-md-8 fs-5 mx-auto text-secondary mt-3">
          基於 Laravel 10 RESTful API 與 Vue 3 SPA 前後端分離架構設計，支援文章、分類與多標籤的完整 CRUD 與關聯管理。
        </p>
        <div class="d-flex justify-content-center gap-3 mt-4">
          <RouterLink to="/articles" class="btn btn-primary btn-lg px-4">進入文章列表</RouterLink>
          <RouterLink to="/articles/create" class="btn btn-outline-primary btn-lg px-4">快速發布文章</RouterLink>
        </div>
      </div>
    </div>

    <div class="row g-4 text-center">
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-body p-4">
            <div class="fs-1 text-primary mb-3">📰</div>
            <h4 class="card-title fw-bold">文章管理</h4>
            <p class="card-text text-muted">檢視、分頁瀏覽、新增與編輯文章內容，支援分類與多對多標籤關聯。</p>
            <RouterLink to="/articles" class="btn btn-outline-primary">管理文章</RouterLink>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-body p-4">
            <div class="fs-1 text-success mb-3">📂</div>
            <h4 class="card-title fw-bold">分類管理</h4>
            <p class="card-text text-muted">自訂文章所屬分類目錄，維護系統分類階層，便於分類歸檔與檢索。</p>
            <RouterLink to="/categories" class="btn btn-outline-success">管理分類</RouterLink>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-body p-4">
            <div class="fs-1 text-info mb-3">🏷️</div>
            <h4 class="card-title fw-bold">標籤管理</h4>
            <p class="card-text text-muted">靈活建立與調整關鍵字標籤，實現一篇多標籤的多元關聯標註。</p>
            <RouterLink to="/tags" class="btn btn-outline-info">管理標籤</RouterLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "HomeView",
};
</script>

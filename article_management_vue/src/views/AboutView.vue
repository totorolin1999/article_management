<template>
  <div class="container my-5">
    <div class="card shadow-sm border-0 col-md-8 mx-auto">
      <div class="card-body p-4 p-md-5">
        <h2 class="card-title fw-bold text-primary mb-3">關於本系統</h2>
        <p class="text-secondary leading-relaxed">
          本系統是一個現代化的文章內容管理平台範例，展示前後端分離架構的最佳實踐。
        </p>

        <h5 class="fw-bold mt-4 mb-3">🛠️ 技術架構</h5>
        <ul class="list-group list-group-flush mb-4">
          <li class="list-group-item"><strong>後端核心：</strong> Laravel 10 (PHP 8.1+) RESTful API</li>
          <li class="list-group-item"><strong>前端技術：</strong> Vue 3 (Vite + Vue Router 4 + Axios)</li>
          <li class="list-group-item"><strong>UI 樣式庫：</strong> Bootstrap 5</li>
          <li class="list-group-item"><strong>互動回饋：</strong> SweetAlert2</li>
          <li class="list-group-item"><strong>關聯架構：</strong> 一對多（文章與分類）、多對多（文章與標籤）</li>
        </ul>

        <div class="text-end">
          <RouterLink to="/" class="btn btn-primary">返回首頁</RouterLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AboutView",
};
</script>

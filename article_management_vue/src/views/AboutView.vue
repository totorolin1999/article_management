<template>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-9">
        <!-- 系統簡介 Header -->
        <div class="card card-modern border-0 mb-4 overflow-hidden">
          <div class="p-4 p-md-5 bg-gradient text-white" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-10 text-white small mb-3">
              <i class="bi bi-patch-check-fill text-info"></i>
              前後端分離架構系統範例
            </div>
            <h1 class="fw-bold mb-2">文章管理系統 (Article Hub)</h1>
            <p class="text-white-50 mb-0 fs-5" style="max-width: 680px;">
              本專案採用前後端分離架構設計，以後端 Laravel 10 提供高效強健的 RESTful API，前端搭配 Vue 3 SPA 提供流暢的單頁應用體驗。
            </p>
          </div>

          <div class="card-body p-4 p-md-5">
            <h4 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
              <i class="bi bi-stack text-primary"></i>
              技術架構一覽
            </h4>

            <div class="row g-3 mb-5">
              <div class="col-md-6">
                <div class="p-3 rounded-3 border bg-light h-100">
                  <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-server text-danger fs-4"></i>
                    <h6 class="fw-bold mb-0 text-dark">後端 (Backend)</h6>
                  </div>
                  <ul class="list-unstyled text-secondary small mb-0 ps-1">
                    <li class="mb-1">• <strong>框架：</strong> Laravel 10 (PHP 8.1+)</li>
                    <li class="mb-1">• <strong>API 架構：</strong> RESTful API 設計原則</li>
                    <li class="mb-1">• <strong>關聯模型：</strong> Eloquent ORM 一對多與多對多</li>
                    <li>• <strong>驗證機制：</strong> FormRequest 完整後端校驗</li>
                  </ul>
                </div>
              </div>

              <div class="col-md-6">
                <div class="p-3 rounded-3 border bg-light h-100">
                  <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-window-sidebar text-success fs-4"></i>
                    <h6 class="fw-bold mb-0 text-dark">前端 (Frontend)</h6>
                  </div>
                  <ul class="list-unstyled text-secondary small mb-0 ps-1">
                    <li class="mb-1">• <strong>框架：</strong> Vue 3 (Composition API / Options API)</li>
                    <li class="mb-1">• <strong>建構工具：</strong> Vite 高速建構引擎</li>
                    <li class="mb-1">• <strong>路由：</strong> Vue Router 4 SPA 單頁路由</li>
                    <li>• <strong>UI 框架：</strong> Bootstrap 5 + Bootstrap Icons</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- 系統核心特色 -->
            <h4 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
              <i class="bi bi-stars text-warning"></i>
              系統亮點與功能特色
            </h4>

            <div class="row g-3 mb-4">
              <div class="col-sm-6">
                <div class="d-flex gap-3 align-items-start">
                  <i class="bi bi-check-circle-fill text-primary fs-5 mt-1"></i>
                  <div>
                    <h6 class="fw-bold text-dark mb-1">文章 CRUD 與分頁</h6>
                    <p class="text-muted small mb-0">支援自訂分頁讀取、即時標題過濾與分類篩選。</p>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="d-flex gap-3 align-items-start">
                  <i class="bi bi-check-circle-fill text-primary fs-5 mt-1"></i>
                  <div>
                    <h6 class="fw-bold text-dark mb-1">即時文章卡片預覽</h6>
                    <p class="text-muted small mb-0">在新增或修改文章時即時預覽外觀，所見即所得。</p>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="d-flex gap-3 align-items-start">
                  <i class="bi bi-check-circle-fill text-primary fs-5 mt-1"></i>
                  <div>
                    <h6 class="fw-bold text-dark mb-1">多對多標籤管理</h6>
                    <p class="text-muted small mb-0">自訂文章標籤晶片，文章可自由多選綁定標籤。</p>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="d-flex gap-3 align-items-start">
                  <i class="bi bi-check-circle-fill text-primary fs-5 mt-1"></i>
                  <div>
                    <h6 class="fw-bold text-dark mb-1">SweetAlert2 交互反饋</h6>
                    <p class="text-muted small mb-0">彈出式成功提示與重要刪除動作二次防呆確認。</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end pt-3 border-top">
              <RouterLink to="/" class="btn btn-primary px-4 shadow-sm">
                <i class="bi bi-house-door"></i>
                返回系統首頁
              </RouterLink>
            </div>
          </div>
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

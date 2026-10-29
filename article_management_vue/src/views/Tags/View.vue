<template>
  <div class="container my-5">
    <!-- 頂部標題與操作列 -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
      <div>
        <h2 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
          <i class="bi bi-tags text-info"></i>
          標籤管理
        </h2>
        <p class="text-muted mb-0 small">管理文章關鍵字標籤，文章支援跨類別多標籤組合</p>
      </div>
      <div class="d-flex gap-2">
        <button @click="getTags" class="btn btn-outline-secondary" title="重新整理">
          <i class="bi bi-arrow-clockwise" :class="{ 'spin-anim': isLoading }"></i>
          <span class="d-none d-sm-inline">整理</span>
        </button>
        <RouterLink to="/tags/create" class="btn btn-info text-white shadow-sm">
          <i class="bi bi-plus-lg"></i>
          新增標籤
        </RouterLink>
      </div>
    </div>

    <!-- 搜尋與過濾 -->
    <div class="card card-modern border-0 mb-4">
      <div class="card-body p-3">
        <div class="row g-2 align-items-center">
          <div class="col-md-6 col-lg-5">
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bi bi-search"></i>
              </span>
              <input
                type="text"
                v-model="searchQuery"
                class="form-control border-start-0 ps-0"
                placeholder="搜尋標籤關鍵字..."
              />
              <button
                v-if="searchQuery"
                @click="searchQuery = ''"
                class="btn btn-outline-secondary border-start-0"
                type="button"
              >
                <i class="bi bi-x"></i>
              </button>
            </div>
          </div>
          <div class="col-md-6 col-lg-7 text-md-end text-muted small">
            共計 <strong>{{ tags.length }}</strong> 個標籤
          </div>
        </div>
      </div>
    </div>

    <!-- 標籤表格 -->
    <div class="card card-modern border-0 overflow-hidden">
      <div class="table-responsive">
        <table class="table-modern align-middle mb-0">
          <thead>
            <tr>
              <th scope="col" style="width: 80px;" class="ps-4">ID</th>
              <th scope="col">標籤預覽</th>
              <th scope="col">標籤名稱</th>
              <th scope="col" style="width: 160px;" class="text-end pe-4">操作</th>
            </tr>
          </thead>

          <!-- 載入狀態 -->
          <tbody v-if="isLoading">
            <tr>
              <td colspan="4" class="text-center py-5">
                <div class="spinner-border text-info mb-3" role="status" style="width: 2.5rem; height: 2.5rem;">
                  <span class="visually-hidden">載入中...</span>
                </div>
                <div class="text-muted fw-medium">標籤清單載入中...</div>
              </td>
            </tr>
          </tbody>

          <!-- 有資料渲染 -->
          <tbody v-else-if="filteredTags.length > 0">
            <tr v-for="tag in filteredTags" :key="tag.id">
              <td class="ps-4">
                <span class="badge bg-light text-secondary border font-monospace">#{{ tag.id }}</span>
              </td>
              <td style="width: 180px;">
                <span class="badge badge-soft-info px-3 py-1 rounded-pill fw-semibold">
                  <i class="bi bi-hash me-1"></i>{{ tag.name }}
                </span>
              </td>
              <td>
                <span class="fw-semibold text-dark">{{ tag.name }}</span>
              </td>
              <td class="text-end pe-4">
                <div class="d-inline-flex gap-1">
                  <RouterLink
                    :to="'/tags/' + tag.id + '/edit'"
                    class="btn btn-sm btn-outline-warning"
                    title="編輯標籤"
                  >
                    <i class="bi bi-pencil-square"></i>
                    <span class="d-none d-md-inline">編輯</span>
                  </RouterLink>
                  <button
                    type="button"
                    @click="deleteTag(tag.id)"
                    class="btn btn-sm btn-outline-danger"
                    title="刪除標籤"
                  >
                    <i class="bi bi-trash3"></i>
                    <span class="d-none d-md-inline">刪除</span>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>

          <!-- 空狀態 -->
          <tbody v-else>
            <tr>
              <td colspan="4" class="text-center py-5">
                <div class="py-4">
                  <div class="display-6 text-muted mb-3">
                    <i class="bi bi-tag"></i>
                  </div>
                  <h5 class="fw-bold text-dark mb-1">
                    {{ searchQuery ? '查無符合條件的標籤' : '目前尚無任何標籤資料' }}
                  </h5>
                  <p class="text-muted small mb-3">
                    {{ searchQuery ? '請嘗試其他關鍵字搜尋。' : '開始建立文章標籤，讓文章內容探索更多元。' }}
                  </p>
                  <button
                    v-if="searchQuery"
                    @click="searchQuery = ''"
                    class="btn btn-outline-secondary btn-sm"
                  >
                    <i class="bi bi-arrow-counterclockwise"></i> 重設搜尋
                  </button>
                  <RouterLink v-else to="/tags/create" class="btn btn-info text-white btn-sm">
                    <i class="bi bi-plus-lg"></i> 立即新增標籤
                  </RouterLink>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import api from "@/services/api";
import { showSuccess, showError, confirmAction } from "@/utils/alert";

export default {
  name: "tags",
  data() {
    return {
      tags: [],
      isLoading: false,
      searchQuery: "",
    };
  },
  computed: {
    filteredTags() {
      if (!this.searchQuery) return this.tags;
      return this.tags.filter((t) =>
        t.name.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
  },
  mounted() {
    this.getTags();
  },
  methods: {
    getTags() {
      this.isLoading = true;
      api.get("/tags")
        .then((res) => {
          this.tags = res.data.tags || [];
        })
        .catch((error) => {
          console.error("載入標籤失敗:", error);
          showError("載入失敗", error.response?.data?.message || "伺服器通訊錯誤");
          this.tags = [];
        })
        .finally(() => {
          this.isLoading = false;
        });
    },

    async deleteTag(tagId) {
      const confirmed = await confirmAction("確定要刪除此標籤嗎？");
      if (!confirmed) return;

      try {
        const res = await api.delete(`/tags/${tagId}`);
        showSuccess(res.data.message || "標籤已成功刪除");
        this.getTags();
      } catch (error) {
        showError("刪除失敗", error.response?.data?.message || "操作失敗");
      }
    },
  },
};
</script>

<style scoped>
.spin-anim {
  display: inline-block;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  100% {
    transform: rotate(360deg);
  }
}
</style>

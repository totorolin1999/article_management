<template>
  <div class="container my-5">
    <!-- 頂部標題與操作列 -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
      <div>
        <h2 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
          <i class="bi bi-folder2-open text-success"></i>
          分類管理
        </h2>
        <p class="text-muted mb-0 small">管理系統文章所屬分類目錄，維持文章結構條理清晰</p>
      </div>
      <div class="d-flex gap-2">
        <button @click="getCategories" class="btn btn-outline-secondary" title="重新整理">
          <i class="bi bi-arrow-clockwise" :class="{ 'spin-anim': isLoading }"></i>
          <span class="d-none d-sm-inline">整理</span>
        </button>
        <RouterLink to="/categories/create" class="btn btn-success text-white shadow-sm">
          <i class="bi bi-plus-lg"></i>
          新增分類
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
                placeholder="搜尋分類名稱..."
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
            共計 <strong>{{ categories.length }}</strong> 個分類目錄
          </div>
        </div>
      </div>
    </div>

    <!-- 分類表格 -->
    <div class="card card-modern border-0 overflow-hidden">
      <div class="table-responsive">
        <table class="table-modern align-middle mb-0">
          <thead>
            <tr>
              <th scope="col" style="width: 80px;" class="ps-4">ID</th>
              <th scope="col">分類名稱</th>
              <th scope="col" style="width: 160px;" class="text-end pe-4">操作</th>
            </tr>
          </thead>

          <!-- 載入狀態 -->
          <tbody v-if="isLoading">
            <tr>
              <td colspan="3" class="text-center py-5">
                <div class="spinner-border text-success mb-3" role="status" style="width: 2.5rem; height: 2.5rem;">
                  <span class="visually-hidden">載入中...</span>
                </div>
                <div class="text-muted fw-medium">分類清單載入中...</div>
              </td>
            </tr>
          </tbody>

          <!-- 有資料渲染 -->
          <tbody v-else-if="filteredCategories.length > 0">
            <tr v-for="category in filteredCategories" :key="category.id">
              <td class="ps-4">
                <span class="badge bg-light text-secondary border font-monospace">#{{ category.id }}</span>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="category-icon-box">
                    <i class="bi bi-folder text-success"></i>
                  </div>
                  <span class="fw-bold text-dark">{{ category.name }}</span>
                </div>
              </td>
              <td class="text-end pe-4">
                <div class="d-inline-flex gap-1">
                  <RouterLink
                    :to="'/categories/' + category.id + '/edit'"
                    class="btn btn-sm btn-outline-warning"
                    title="編輯分類"
                  >
                    <i class="bi bi-pencil-square"></i>
                    <span class="d-none d-md-inline">編輯</span>
                  </RouterLink>
                  <button
                    type="button"
                    @click="deleteCategory(category.id)"
                    class="btn btn-sm btn-outline-danger"
                    title="刪除分類"
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
              <td colspan="3" class="text-center py-5">
                <div class="py-4">
                  <div class="display-6 text-muted mb-3">
                    <i class="bi bi-folder-x"></i>
                  </div>
                  <h5 class="fw-bold text-dark mb-1">
                    {{ searchQuery ? '查無符合條件的分類' : '目前尚無任何分類資料' }}
                  </h5>
                  <p class="text-muted small mb-3">
                    {{ searchQuery ? '請嘗試其他關鍵字搜尋。' : '開始建立第一個文章分類以歸類您的內容。' }}
                  </p>
                  <button
                    v-if="searchQuery"
                    @click="searchQuery = ''"
                    class="btn btn-outline-secondary btn-sm"
                  >
                    <i class="bi bi-arrow-counterclockwise"></i> 重設搜尋
                  </button>
                  <RouterLink v-else to="/categories/create" class="btn btn-success text-white btn-sm">
                    <i class="bi bi-plus-lg"></i> 立即新增分類
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
  name: "categories",
  data() {
    return {
      categories: [],
      isLoading: false,
      searchQuery: "",
    };
  },
  computed: {
    filteredCategories() {
      if (!this.searchQuery) return this.categories;
      return this.categories.filter((cat) =>
        cat.name.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
  },
  mounted() {
    this.getCategories();
  },
  methods: {
    getCategories() {
      this.isLoading = true;
      api.get("/categories")
        .then((res) => {
          this.categories = res.data.categories || [];
        })
        .catch((error) => {
          console.error("載入分類失敗:", error);
          showError("載入失敗", error.response?.data?.message || "伺服器通訊錯誤");
          this.categories = [];
        })
        .finally(() => {
          this.isLoading = false;
        });
    },

    async deleteCategory(categoryId) {
      const confirmed = await confirmAction("確定要刪除此分類嗎？刪除分類將可能影響關聯文章。");
      if (!confirmed) return;

      try {
        const res = await api.delete(`/categories/${categoryId}`);
        showSuccess(res.data.message || "分類已成功刪除");
        this.getCategories();
      } catch (error) {
        showError("刪除失敗", error.response?.data?.message || "操作失敗");
      }
    },
  },
};
</script>

<style scoped>
.category-icon-box {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background-color: #ecfdf5;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
}

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

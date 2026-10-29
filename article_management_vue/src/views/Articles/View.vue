<template>
  <div class="container my-5">
    <!-- 頂部頁頭與操作區 -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
      <div>
        <h2 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
          <i class="bi bi-file-earmark-text text-primary"></i>
          文章列表
        </h2>
        <p class="text-muted mb-0 small">管理與瀏覽所有已發布的文章內容與關聯標籤</p>
      </div>
      <div class="d-flex gap-2">
        <button @click="getArticles" class="btn btn-outline-secondary" title="重新整理">
          <i class="bi bi-arrow-clockwise" :class="{ 'spin-anim': isLoading }"></i>
          <span class="d-none d-sm-inline">整理</span>
        </button>
        <RouterLink to="/articles/create" class="btn btn-primary shadow-sm">
          <i class="bi bi-plus-lg"></i>
          新增文章
        </RouterLink>
      </div>
    </div>

    <!-- 搜尋與過濾篩選列 -->
    <div class="card card-modern border-0 mb-4">
      <div class="card-body p-3">
        <div class="row g-2 align-items-center">
          <div class="col-md-7 col-lg-8">
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bi bi-search"></i>
              </span>
              <input
                type="text"
                v-model="searchQuery"
                class="form-control border-start-0 ps-0"
                placeholder="搜尋文章標題或網址關鍵字..."
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
          <div class="col-md-5 col-lg-4">
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bi bi-filter"></i>
              </span>
              <select v-model="selectedCategory" class="form-select border-start-0">
                <option value="">所有分類 (全部)</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                  {{ cat.name }}
                </option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 文章表格卡片 -->
    <div class="card card-modern border-0 overflow-hidden">
      <div class="table-responsive">
        <table class="table-modern align-middle mb-0">
          <thead>
            <tr>
              <th scope="col" style="width: 70px;" class="ps-4">ID</th>
              <th scope="col">標題</th>
              <th scope="col" style="min-width: 180px;">外部連結</th>
              <th scope="col" style="width: 140px;">分類</th>
              <th scope="col" style="min-width: 160px;">標籤</th>
              <th scope="col" style="width: 140px;" class="text-end pe-4">操作</th>
            </tr>
          </thead>

          <!-- 載入中狀態 -->
          <tbody v-if="isLoading">
            <tr>
              <td colspan="6" class="text-center py-5">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 2.5rem; height: 2.5rem;">
                  <span class="visually-hidden">載入中...</span>
                </div>
                <div class="text-muted fw-medium">文章資料載入中，請稍候...</div>
              </td>
            </tr>
          </tbody>

          <!-- 有資料渲染列表 -->
          <tbody v-else-if="filteredArticles.length > 0">
            <tr v-for="article in filteredArticles" :key="article.id">
              <td class="ps-4">
                <span class="badge bg-light text-secondary border font-monospace">#{{ article.id }}</span>
              </td>
              <td>
                <div class="fw-semibold text-dark">{{ article.title }}</div>
              </td>
              <td>
                <div class="d-flex align-items-center gap-1">
                  <a
                    :href="article.link"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-decoration-none text-truncate d-inline-block text-primary small"
                    style="max-width: 220px;"
                    :title="article.link"
                  >
                    <i class="bi bi-box-arrow-up-right me-1"></i>
                    {{ article.link }}
                  </a>
                </div>
              </td>
              <td>
                <span v-if="article.category?.name" class="badge badge-soft-primary px-2 py-1 rounded-pill small">
                  <i class="bi bi-folder2 me-1"></i>{{ article.category.name }}
                </span>
                <span v-else class="badge badge-soft-secondary px-2 py-1 rounded-pill small">
                  未分類
                </span>
              </td>
              <td>
                <div class="d-flex flex-wrap gap-1">
                  <span
                    v-for="tag in article.tags"
                    :key="tag.id"
                    class="badge badge-soft-info px-2 py-1 rounded-pill small"
                  >
                    #{{ tag.name }}
                  </span>
                  <span v-if="!article.tags || article.tags.length === 0" class="text-muted small">
                    —
                  </span>
                </div>
              </td>
              <td class="text-end pe-4">
                <div class="d-inline-flex gap-1">
                  <RouterLink
                    :to="'/articles/' + article.id + '/edit'"
                    class="btn btn-sm btn-outline-warning"
                    title="編輯文章"
                  >
                    <i class="bi bi-pencil-square"></i>
                    <span class="d-none d-md-inline">編輯</span>
                  </RouterLink>
                  <button
                    type="button"
                    @click="deleteArticle(article.id)"
                    class="btn btn-sm btn-outline-danger"
                    title="刪除文章"
                  >
                    <i class="bi bi-trash3"></i>
                    <span class="d-none d-md-inline">刪除</span>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>

          <!-- 無符合篩選或空資料狀態 -->
          <tbody v-else>
            <tr>
              <td colspan="6" class="text-center py-5">
                <div class="py-4">
                  <div class="display-6 text-muted mb-3">
                    <i class="bi bi-inbox"></i>
                  </div>
                  <h5 class="fw-bold text-dark mb-1">
                    {{ searchQuery || selectedCategory ? '查無符合條件的文章' : '目前尚無文章資料' }}
                  </h5>
                  <p class="text-muted small mb-3">
                    {{ searchQuery || selectedCategory ? '請嘗試調整搜尋關鍵字或分類篩選條件。' : '點擊下方按鈕立即發布您的第一篇文章！' }}
                  </p>
                  <button
                    v-if="searchQuery || selectedCategory"
                    @click="clearFilters"
                    class="btn btn-outline-secondary btn-sm"
                  >
                    <i class="bi bi-arrow-counterclockwise"></i> 清除篩選條件
                  </button>
                  <RouterLink v-else to="/articles/create" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> 立即新增文章
                  </RouterLink>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- 分頁控制項 -->
      <div class="card-footer bg-white border-top py-3 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2" v-if="pageCount > 1">
        <span class="text-muted small">
          第 <strong>{{ page }}</strong> 頁 / 共 <strong>{{ pageCount }}</strong> 頁
        </span>
        <v-pagination
          v-model="page"
          :pages="pageCount"
          :range-size="1"
          active-color="#3b82f6"
          @update:modelValue="getArticles"
        />
      </div>
    </div>
  </div>
</template>

<script>
import api from "@/services/api";
import { showSuccess, showError, confirmAction } from "@/utils/alert";
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";

export default {
  name: "articles",
  components: {
    VPagination,
  },
  data() {
    return {
      articles: [],
      categories: [],
      page: 1,
      pageCount: 1,
      isLoading: false,
      searchQuery: "",
      selectedCategory: "",
    };
  },
  computed: {
    filteredArticles() {
      return this.articles.filter((article) => {
        const matchesQuery =
          !this.searchQuery ||
          article.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          article.link.toLowerCase().includes(this.searchQuery.toLowerCase());

        const matchesCategory =
          !this.selectedCategory ||
          String(article.category_id) === String(this.selectedCategory) ||
          String(article.category?.id) === String(this.selectedCategory);

        return matchesQuery && matchesCategory;
      });
    },
  },
  mounted() {
    this.getArticles();
    this.loadCategories();
  },
  methods: {
    async loadCategories() {
      try {
        const res = await api.get("/categories");
        this.categories = res.data.categories || [];
      } catch (e) {
        console.error("載入分類選項失敗", e);
      }
    },

    getArticles() {
      this.isLoading = true;
      api.get(`/articles?page=${this.page}`)
        .then((res) => {
          this.pageCount = res.data.pageCount || 1;
          this.articles = res.data.paginate?.data || [];
        })
        .catch((error) => {
          console.error("載入文章失敗:", error);
          showError("載入文章失敗", error.response?.data?.message || "伺服器通訊錯誤");
          this.articles = [];
        })
        .finally(() => {
          this.isLoading = false;
        });
    },

    clearFilters() {
      this.searchQuery = "";
      this.selectedCategory = "";
    },

    async deleteArticle(articleId) {
      const confirmed = await confirmAction("確定要刪除這篇文章嗎？此動作無法還原。");
      if (!confirmed) return;

      try {
        const res = await api.delete(`/articles/${articleId}`);
        showSuccess(res.data.message || "文章已成功刪除");
        this.getArticles();
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

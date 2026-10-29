<template>
  <div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>文章列表</h2>
      <RouterLink to="/articles/create" class="btn btn-primary">新增文章</RouterLink>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th scope="col" style="width: 80px;">ID</th>
            <th scope="col">標題</th>
            <th scope="col">連結</th>
            <th scope="col">分類</th>
            <th scope="col">標籤</th>
            <th scope="col" style="width: 160px;">操作</th>
          </tr>
        </thead>
        <tbody v-if="isLoading">
          <tr>
            <td colspan="6" class="text-center py-4">正在載入中...</td>
          </tr>
        </tbody>
        <tbody v-else-if="articles.length > 0">
          <tr v-for="article in articles" :key="article.id">
            <th scope="row">{{ article.id }}</th>
            <td>{{ article.title }}</td>
            <td>
              <a :href="article.link" target="_blank" rel="noopener noreferrer" class="text-truncate d-inline-block" style="max-width: 250px;">
                {{ article.link }}
              </a>
            </td>
            <td>
              <span class="badge bg-secondary">{{ article.category?.name || '無分類' }}</span>
            </td>
            <td>
              <span v-for="tag in article.tags" :key="tag.id" class="badge bg-info text-dark me-1">
                {{ tag.name }}
              </span>
              <span v-if="!article.tags || article.tags.length === 0" class="text-muted small">無標籤</span>
            </td>
            <td>
              <RouterLink :to="'/articles/' + article.id + '/edit'" class="btn btn-sm btn-warning me-2">編輯</RouterLink>
              <button type="button" @click="deleteArticle(article.id)" class="btn btn-sm btn-danger">刪除</button>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td colspan="6" class="text-center py-4 text-muted">目前尚無任何文章資料</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-center mt-4" v-if="pageCount > 1">
      <v-pagination
        v-model="page"
        :pages="pageCount"
        :range-size="1"
        active-color="#DCEDFF"
        @update:modelValue="getArticles"
      />
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
      page: 1,
      pageCount: 1,
      isLoading: false,
    };
  },
  mounted() {
    this.getArticles();
  },
  methods: {
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

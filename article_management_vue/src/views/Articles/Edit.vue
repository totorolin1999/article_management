<template>
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
        <h4 class="mb-0">編輯文章</h4>
        <RouterLink to="/articles" class="btn btn-sm btn-outline-dark">返回列表</RouterLink>
      </div>
      <div class="card-body">
        <div class="alert alert-danger" v-if="errorList && Object.keys(errorList).length > 0">
          <ul class="mb-0 ps-3">
            <li v-for="(errors, key) in errorList" :key="key">{{ errors[0] }}</li>
          </ul>
        </div>

        <div v-if="isLoading" class="text-center py-4">正在載入文章資料...</div>

        <form v-else @submit.prevent="updateArticle">
          <div class="mb-3">
            <label class="form-label fw-bold">標題 <span class="text-danger">*</span></label>
            <input type="text" v-model="form.title" class="form-control" placeholder="請輸入文章標題" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">連結 (URL) <span class="text-danger">*</span></label>
            <input type="url" v-model="form.link" class="form-control" placeholder="https://example.com" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">分類 <span class="text-danger">*</span></label>
            <select class="form-select" v-model="form.category_id" required>
              <option value="">請選擇分類</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold d-block">標籤</label>
            <div class="d-flex flex-wrap gap-2">
              <div class="form-check" v-for="tag in tags" :key="tag.id">
                <input
                  class="form-check-input"
                  type="checkbox"
                  :id="'edit-tag-' + tag.id"
                  :value="tag.id"
                  v-model="form.tag_id"
                >
                <label class="form-check-label" :for="'edit-tag-' + tag.id">
                  {{ tag.name }}
                </label>
              </div>
              <span v-if="tags.length === 0" class="text-muted small">尚無標籤可選</span>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <RouterLink to="/articles" class="btn btn-secondary">取消</RouterLink>
            <button type="submit" class="btn btn-warning" :disabled="isSubmitting">
              {{ isSubmitting ? '更新中...' : '更新' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import api from "@/services/api";
import { showSuccess, showError } from "@/utils/alert";

export default {
  name: "articleEdit",
  data() {
    return {
      articleId: "",
      errorList: null,
      isLoading: false,
      isSubmitting: false,
      form: {
        title: "",
        link: "",
        category_id: "",
        tag_id: [],
      },
      categories: [],
      tags: [],
    };
  },
  mounted() {
    this.articleId = this.$route.params.id;
    this.initData();
  },
  methods: {
    async initData() {
      this.isLoading = true;
      try {
        const [catRes, tagRes, articleRes] = await Promise.all([
          api.get("/categories"),
          api.get("/tags"),
          api.get(`/articles/${this.articleId}/edit`),
        ]);

        this.categories = catRes.data.categories || [];
        this.tags = tagRes.data.tags || [];

        const article = articleRes.data.article;
        this.form = {
          title: article.title || "",
          link: article.link || "",
          category_id: article.category_id || "",
          tag_id: Array.isArray(article.tags) ? article.tags.map((t) => t.id) : [],
        };
      } catch (error) {
        showError("載入失敗", error.response?.data?.message || "無法載入文章資料");
        this.$router.push("/articles");
      } finally {
        this.isLoading = false;
      }
    },

    async updateArticle() {
      this.isSubmitting = true;
      this.errorList = null;

      try {
        const res = await api.put(`/articles/${this.articleId}`, this.form);
        await showSuccess(res.data.message || "文章更新成功");
        this.$router.push("/articles");
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errorList = error.response.data.errors;
        } else {
          showError("更新失敗", error.response?.data?.message || "伺服器發生錯誤");
        }
      } finally {
        this.isSubmitting = false;
      }
    },
  },
};
</script>

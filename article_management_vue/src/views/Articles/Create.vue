<template>
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">新增文章</h4>
        <RouterLink to="/articles" class="btn btn-sm btn-light">返回列表</RouterLink>
      </div>
      <div class="card-body">
        <div class="alert alert-danger" v-if="errorList && Object.keys(errorList).length > 0">
          <ul class="mb-0 ps-3">
            <li v-for="(errors, key) in errorList" :key="key">{{ errors[0] }}</li>
          </ul>
        </div>

        <form @submit.prevent="saveArticle">
          <div class="mb-3">
            <label class="form-label fw-bold">標題 <span class="text-danger">*</span></label>
            <input type="text" v-model="model.article.title" class="form-control" placeholder="請輸入文章標題" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">連結 (URL) <span class="text-danger">*</span></label>
            <input type="url" v-model="model.article.link" class="form-control" placeholder="https://example.com" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">分類 <span class="text-danger">*</span></label>
            <select class="form-select" v-model="model.article.category_id" required>
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
                  :id="'tag-' + tag.id"
                  :value="tag.id"
                  v-model="model.article.tag_id"
                >
                <label class="form-check-label" :for="'tag-' + tag.id">
                  {{ tag.name }}
                </label>
              </div>
              <span v-if="tags.length === 0" class="text-muted small">尚無標籤可選</span>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <RouterLink to="/articles" class="btn btn-secondary">取消</RouterLink>
            <button type="submit" class="btn btn-primary" :disabled="isSubmitting">
              {{ isSubmitting ? '儲存中...' : '儲存' }}
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
  name: "articleCreate",
  data() {
    return {
      errorList: null,
      isSubmitting: false,
      model: {
        article: {
          title: "",
          link: "",
          category_id: "",
          tag_id: [],
        },
      },
      categories: [],
      tags: [],
    };
  },
  mounted() {
    this.loadFormData();
  },
  methods: {
    async loadFormData() {
      try {
        const [catRes, tagRes] = await Promise.all([
          api.get("/categories"),
          api.get("/tags"),
        ]);
        this.categories = catRes.data.categories || [];
        this.tags = tagRes.data.tags || [];
      } catch (error) {
        console.error("載入分類或標籤失敗:", error);
      }
    },

    async saveArticle() {
      this.isSubmitting = true;
      this.errorList = null;

      try {
        const res = await api.post("/articles", this.model.article);
        await showSuccess(res.data.message || "文章建立成功");
        this.$router.push("/articles");
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errorList = error.response.data.errors;
        } else {
          showError("儲存失敗", error.response?.data?.message || "伺服器發生錯誤");
        }
      } finally {
        this.isSubmitting = false;
      }
    },
  },
};
</script>

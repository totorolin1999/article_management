<template>
  <div class="container my-5">
    <!-- 頂部頁頭 -->
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><RouterLink to="/articles">文章列表</RouterLink></li>
            <li class="breadcrumb-item active" aria-current="page">新增文章</li>
          </ol>
        </nav>
        <h2 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
          <i class="bi bi-pencil-square text-primary"></i>
          新增文章
        </h2>
      </div>
      <RouterLink to="/articles" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
        返回列表
      </RouterLink>
    </div>

    <div class="row g-4">
      <!-- 左側：輸入表單 -->
      <div class="col-lg-7">
        <div class="card card-modern border-0">
          <div class="card-header-modern">
            <h5 class="fw-bold text-dark mb-0">文章基本資訊</h5>
            <small class="text-muted">填寫文章標題、來源連結、所屬分類與標籤</small>
          </div>
          <div class="card-body p-4">
            <!-- 驗證錯誤提示 -->
            <div class="alert alert-danger d-flex align-items-center gap-2" v-if="errorList && Object.keys(errorList).length > 0">
              <i class="bi bi-exclamation-triangle-fill fs-5"></i>
              <div>
                <ul class="mb-0 ps-3">
                  <li v-for="(errors, key) in errorList" :key="key">{{ errors[0] }}</li>
                </ul>
              </div>
            </div>

            <form @submit.prevent="saveArticle">
              <!-- 文章標題 -->
              <div class="mb-4">
                <label class="form-label fw-bold text-secondary">
                  文章標題 <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light text-muted">
                    <i class="bi bi-fonts"></i>
                  </span>
                  <input
                    type="text"
                    v-model="model.article.title"
                    class="form-control"
                    placeholder="請輸入清楚吸睛的文章標題"
                    required
                  />
                </div>
              </div>

              <!-- 外部連結 -->
              <div class="mb-4">
                <label class="form-label fw-bold text-secondary">
                  外部連結 (URL) <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light text-muted">
                    <i class="bi bi-link-45deg"></i>
                  </span>
                  <input
                    type="url"
                    v-model="model.article.link"
                    class="form-control"
                    placeholder="https://example.com/article"
                    required
                  />
                </div>
              </div>

              <!-- 分類下拉 -->
              <div class="mb-4">
                <label class="form-label fw-bold text-secondary">
                  文章分類 <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light text-muted">
                    <i class="bi bi-folder2"></i>
                  </span>
                  <select class="form-select" v-model="model.article.category_id" required>
                    <option value="">請選擇適當的分類目錄</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                      {{ category.name }}
                    </option>
                  </select>
                </div>
              </div>

              <!-- 標籤晶片選擇器 -->
              <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <label class="form-label fw-bold text-secondary mb-0">
                    關聯標籤 (可多選)
                  </label>
                  <span class="badge bg-light text-muted border small">
                    已選 {{ model.article.tag_id.length }} 個
                  </span>
                </div>
                <div class="d-flex flex-wrap gap-2 pt-1">
                  <div
                    v-for="tag in tags"
                    :key="tag.id"
                    class="tag-chip"
                    :class="{ active: model.article.tag_id.includes(tag.id) }"
                    @click="toggleTag(tag.id)"
                  >
                    <i class="bi" :class="model.article.tag_id.includes(tag.id) ? 'bi-check2' : 'bi-hash'"></i>
                    {{ tag.name }}
                  </div>
                  <div v-if="tags.length === 0" class="text-muted small py-1">
                    尚未建立標籤，可至「文章標籤」功能預先建立
                  </div>
                </div>
              </div>

              <hr class="my-4 text-muted opacity-25" />

              <!-- 操作按鈕 -->
              <div class="d-flex justify-content-end gap-2">
                <RouterLink to="/articles" class="btn btn-light border px-4">
                  取消
                </RouterLink>
                <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="isSubmitting">
                  <span v-if="isSubmitting" class="spinner-border spinner-border-sm" role="status"></span>
                  <i v-else class="bi bi-check-lg"></i>
                  {{ isSubmitting ? '儲存中...' : '確認發布' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- 右側：即時預覽卡片 -->
      <div class="col-lg-5">
        <div class="card card-modern border-0 sticky-top" style="top: 90px;">
          <div class="card-header-modern d-flex align-items-center justify-content-between">
            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
              <i class="bi bi-eye text-primary"></i>
              即時預覽 (Live Preview)
            </h6>
            <span class="badge badge-soft-primary small">實時同步</span>
          </div>
          <div class="card-body p-4">
            <div class="preview-box p-4 rounded-4 border bg-white">
              <div class="d-flex align-items-center gap-2 mb-3">
                <span class="badge badge-soft-primary rounded-pill px-3 py-1">
                  <i class="bi bi-folder2 me-1"></i>
                  {{ selectedCategoryName || '未指定分類' }}
                </span>
                <span class="text-muted small ms-auto">
                  <i class="bi bi-clock me-1"></i>剛剛
                </span>
              </div>

              <h4 class="fw-bold text-dark mb-2 text-break">
                {{ model.article.title || '文章標題預覽...' }}
              </h4>

              <div class="mb-3">
                <a
                  :href="model.article.link || '#'"
                  target="_blank"
                  class="text-decoration-none text-primary small d-flex align-items-center gap-1 text-break"
                >
                  <i class="bi bi-link-45deg fs-6"></i>
                  <span class="text-truncate">{{ model.article.link || 'https://example.com' }}</span>
                </a>
              </div>

              <div class="d-flex flex-wrap gap-1 pt-2 border-top">
                <span
                  v-for="tag in selectedTagObjects"
                  :key="tag.id"
                  class="badge badge-soft-info rounded-pill px-2 py-1 small"
                >
                  #{{ tag.name }}
                </span>
                <span v-if="selectedTagObjects.length === 0" class="text-muted small">
                  暫無選擇標籤
                </span>
              </div>
            </div>

            <div class="text-muted small mt-3 text-center">
              <i class="bi bi-info-circle me-1"></i>在左側輸入資料即可在此實時預覽卡片呈現樣貌
            </div>
          </div>
        </div>
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
  computed: {
    selectedCategoryName() {
      const found = this.categories.find((c) => String(c.id) === String(this.model.article.category_id));
      return found ? found.name : "";
    },
    selectedTagObjects() {
      return this.tags.filter((t) => this.model.article.tag_id.includes(t.id));
    },
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

    toggleTag(tagId) {
      const index = this.model.article.tag_id.indexOf(tagId);
      if (index === -1) {
        this.model.article.tag_id.push(tagId);
      } else {
        this.model.article.tag_id.splice(index, 1);
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

<style scoped>
.preview-box {
  background: #f8fafc;
  border: 1px dashed #cbd5e1 !important;
  transition: all 0.2s ease;
}
</style>

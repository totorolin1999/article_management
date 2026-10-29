<template>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-6">
        <!-- 導航麵包屑 -->
        <nav aria-label="breadcrumb" class="mb-3">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><RouterLink to="/tags">標籤列表</RouterLink></li>
            <li class="breadcrumb-item active" aria-current="page">新增標籤</li>
          </ol>
        </nav>

        <div class="card card-modern border-0">
          <div class="card-header-modern d-flex justify-content-between align-items-center">
            <div>
              <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-tag-fill text-info"></i>
                新增文章標籤
              </h5>
              <small class="text-muted">建立新的關鍵字標籤，文章可多選綁定</small>
            </div>
            <RouterLink to="/tags" class="btn btn-sm btn-outline-secondary">
              返回
            </RouterLink>
          </div>

          <div class="card-body p-4">
            <div class="alert alert-danger d-flex align-items-center gap-2" v-if="errorList && Object.keys(errorList).length > 0">
              <i class="bi bi-exclamation-triangle-fill fs-5"></i>
              <div>
                <ul class="mb-0 ps-3">
                  <li v-for="(errors, key) in errorList" :key="key">{{ errors[0] }}</li>
                </ul>
              </div>
            </div>

            <form @submit.prevent="saveTag">
              <div class="mb-4">
                <label class="form-label fw-bold text-secondary">
                  標籤名稱 <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light text-muted">
                    <i class="bi bi-hash"></i>
                  </span>
                  <input
                    type="text"
                    v-model="form.name"
                    class="form-control"
                    placeholder="例如：Vue3、Laravel、全端開發、API"
                    required
                  />
                </div>
                <div class="form-text">標籤建議為獨立且具體的關鍵字詞。</div>
              </div>

              <!-- 標籤即時預覽 -->
              <div class="mb-4 p-3 bg-light rounded-3" v-if="form.name">
                <div class="text-muted small mb-1">標籤外觀預覽：</div>
                <span class="badge badge-soft-info px-3 py-1 rounded-pill fw-semibold">
                  <i class="bi bi-hash me-1"></i>{{ form.name }}
                </span>
              </div>

              <div class="d-flex justify-content-end gap-2 pt-2">
                <RouterLink to="/tags" class="btn btn-light border px-4">取消</RouterLink>
                <button type="submit" class="btn btn-info text-white px-4 shadow-sm" :disabled="isSubmitting">
                  <span v-if="isSubmitting" class="spinner-border spinner-border-sm" role="status"></span>
                  <i v-else class="bi bi-check-lg"></i>
                  {{ isSubmitting ? '儲存中...' : '確認儲存' }}
                </button>
              </div>
            </form>
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
  name: "tagCreate",
  data() {
    return {
      errorList: null,
      isSubmitting: false,
      form: {
        name: "",
      },
    };
  },
  methods: {
    async saveTag() {
      this.isSubmitting = true;
      this.errorList = null;

      try {
        const res = await api.post("/tags", this.form);
        await showSuccess(res.data.message || "標籤建立成功");
        this.$router.push("/tags");
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

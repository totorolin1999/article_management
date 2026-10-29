<template>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-6">
        <!-- 導航麵包屑 -->
        <nav aria-label="breadcrumb" class="mb-3">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><RouterLink to="/tags">標籤列表</RouterLink></li>
            <li class="breadcrumb-item active" aria-current="page">編輯標籤</li>
          </ol>
        </nav>

        <div class="card card-modern border-0">
          <div class="card-header-modern d-flex justify-content-between align-items-center">
            <div>
              <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square text-warning"></i>
                編輯標籤資訊
              </h5>
              <small class="text-muted">變更標籤名稱，更新將同步於關聯文章</small>
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

            <!-- 載入中 -->
            <div v-if="isLoading" class="text-center py-5">
              <div class="spinner-border text-info mb-2" role="status">
                <span class="visually-hidden">載入中...</span>
              </div>
              <div class="text-muted small">載入標籤資料中...</div>
            </div>

            <!-- 表單 -->
            <form v-else @submit.prevent="updateTag">
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
                    placeholder="請輸入標籤名稱"
                    required
                  />
                </div>
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
                <button type="submit" class="btn btn-warning px-4 shadow-sm text-dark fw-bold" :disabled="isSubmitting">
                  <span v-if="isSubmitting" class="spinner-border spinner-border-sm" role="status"></span>
                  <i v-else class="bi bi-check2-circle"></i>
                  {{ isSubmitting ? '更新中...' : '儲存變更' }}
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
  name: "tagEdit",
  data() {
    return {
      tagId: "",
      errorList: null,
      isLoading: false,
      isSubmitting: false,
      form: {
        name: "",
      },
    };
  },
  mounted() {
    this.tagId = this.$route.params.id;
    this.getTagData();
  },
  methods: {
    async getTagData() {
      this.isLoading = true;
      try {
        const res = await api.get(`/tags/${this.tagId}`);
        this.form.name = res.data.tag?.name || "";
      } catch (error) {
        showError("載入失敗", error.response?.data?.message || "找不到該標籤");
        this.$router.push("/tags");
      } finally {
        this.isLoading = false;
      }
    },

    async updateTag() {
      this.isSubmitting = true;
      this.errorList = null;

      try {
        const res = await api.put(`/tags/${this.tagId}`, this.form);
        await showSuccess(res.data.message || "標籤更新成功");
        this.$router.push("/tags");
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

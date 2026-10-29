<template>
  <div class="container mt-5">
    <div class="card shadow-sm col-md-8 mx-auto">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">新增標籤</h4>
        <RouterLink to="/tags" class="btn btn-sm btn-light">返回列表</RouterLink>
      </div>
      <div class="card-body">
        <div class="alert alert-danger" v-if="errorList && Object.keys(errorList).length > 0">
          <ul class="mb-0 ps-3">
            <li v-for="(errors, key) in errorList" :key="key">{{ errors[0] }}</li>
          </ul>
        </div>

        <form @submit.prevent="saveTag">
          <div class="mb-3">
            <label class="form-label fw-bold">標籤名稱 <span class="text-danger">*</span></label>
            <input type="text" v-model="form.name" class="form-control" placeholder="請輸入標籤名稱" required>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <RouterLink to="/tags" class="btn btn-secondary">取消</RouterLink>
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

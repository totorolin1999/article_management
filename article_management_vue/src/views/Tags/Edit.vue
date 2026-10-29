<template>
  <div class="container mt-5">
    <div class="card shadow-sm col-md-8 mx-auto">
      <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
        <h4 class="mb-0">編輯標籤</h4>
        <RouterLink to="/tags" class="btn btn-sm btn-outline-dark">返回列表</RouterLink>
      </div>
      <div class="card-body">
        <div class="alert alert-danger" v-if="errorList && Object.keys(errorList).length > 0">
          <ul class="mb-0 ps-3">
            <li v-for="(errors, key) in errorList" :key="key">{{ errors[0] }}</li>
          </ul>
        </div>

        <div v-if="isLoading" class="text-center py-4">正在載入標籤資料...</div>

        <form v-else @submit.prevent="updateTag">
          <div class="mb-3">
            <label class="form-label fw-bold">標籤名稱 <span class="text-danger">*</span></label>
            <input type="text" v-model="form.name" class="form-control" placeholder="請輸入標籤名稱" required>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <RouterLink to="/tags" class="btn btn-secondary">取消</RouterLink>
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

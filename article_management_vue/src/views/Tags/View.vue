<template>
  <div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>標籤列表</h2>
      <RouterLink to="/tags/create" class="btn btn-primary">新增標籤</RouterLink>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th scope="col" style="width: 80px;">ID</th>
            <th scope="col">標籤名稱</th>
            <th scope="col" style="width: 160px;">操作</th>
          </tr>
        </thead>
        <tbody v-if="isLoading">
          <tr>
            <td colspan="3" class="text-center py-4">正在載入中...</td>
          </tr>
        </tbody>
        <tbody v-else-if="tags.length > 0">
          <tr v-for="tag in tags" :key="tag.id">
            <th scope="row">{{ tag.id }}</th>
            <td><span class="badge bg-info text-dark">{{ tag.name }}</span></td>
            <td>
              <RouterLink :to="'/tags/' + tag.id + '/edit'" class="btn btn-sm btn-warning me-2">編輯</RouterLink>
              <button type="button" @click="deleteTag(tag.id)" class="btn btn-sm btn-danger">刪除</button>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td colspan="3" class="text-center py-4 text-muted">目前尚無任何標籤資料</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import api from "@/services/api";
import { showSuccess, showError, confirmAction } from "@/utils/alert";

export default {
  name: "tags",
  data() {
    return {
      tags: [],
      isLoading: false,
    };
  },
  mounted() {
    this.getTags();
  },
  methods: {
    getTags() {
      this.isLoading = true;
      api.get("/tags")
        .then((res) => {
          this.tags = res.data.tags || [];
        })
        .catch((error) => {
          console.error("載入標籤失敗:", error);
          showError("載入失敗", error.response?.data?.message || "伺服器通訊錯誤");
          this.tags = [];
        })
        .finally(() => {
          this.isLoading = false;
        });
    },

    async deleteTag(tagId) {
      const confirmed = await confirmAction("確定要刪除此標籤嗎？");
      if (!confirmed) return;

      try {
        const res = await api.delete(`/tags/${tagId}`);
        showSuccess(res.data.message || "標籤已成功刪除");
        this.getTags();
      } catch (error) {
        showError("刪除失敗", error.response?.data?.message || "操作失敗");
      }
    },
  },
};
</script>

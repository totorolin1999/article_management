<template>
  <div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>分類列表</h2>
      <RouterLink to="/categories/create" class="btn btn-primary">新增分類</RouterLink>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th scope="col" style="width: 80px;">ID</th>
            <th scope="col">分類名稱</th>
            <th scope="col" style="width: 160px;">操作</th>
          </tr>
        </thead>
        <tbody v-if="isLoading">
          <tr>
            <td colspan="3" class="text-center py-4">正在載入中...</td>
          </tr>
        </tbody>
        <tbody v-else-if="categories.length > 0">
          <tr v-for="category in categories" :key="category.id">
            <th scope="row">{{ category.id }}</th>
            <td>{{ category.name }}</td>
            <td>
              <RouterLink :to="'/categories/' + category.id + '/edit'" class="btn btn-sm btn-warning me-2">編輯</RouterLink>
              <button type="button" @click="deleteCategory(category.id)" class="btn btn-sm btn-danger">刪除</button>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td colspan="3" class="text-center py-4 text-muted">目前尚無任何分類資料</td>
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
  name: "categories",
  data() {
    return {
      categories: [],
      isLoading: false,
    };
  },
  mounted() {
    this.getCategories();
  },
  methods: {
    getCategories() {
      this.isLoading = true;
      api.get("/categories")
        .then((res) => {
          this.categories = res.data.categories || [];
        })
        .catch((error) => {
          console.error("載入分類失敗:", error);
          showError("載入失敗", error.response?.data?.message || "伺服器通訊錯誤");
          this.categories = [];
        })
        .finally(() => {
          this.isLoading = false;
        });
    },

    async deleteCategory(categoryId) {
      const confirmed = await confirmAction("確定要刪除此分類嗎？刪除分類將可能影響關聯文章。");
      if (!confirmed) return;

      try {
        const res = await api.delete(`/categories/${categoryId}`);
        showSuccess(res.data.message || "分類已成功刪除");
        this.getCategories();
      } catch (error) {
        showError("刪除失敗", error.response?.data?.message || "操作失敗");
      }
    },
  },
};
</script>

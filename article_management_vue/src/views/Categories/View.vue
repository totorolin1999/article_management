<template>
    <div class="container mt-5 mb-5">
        <RouterLink to="/categories/create" class="btn btn-primary">新增</RouterLink>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">名稱</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody v-if="this.categories.length > 0">
                <tr v-for="(category, index) in this.categories" :key="index">
                    <th scope="row">{{ category.id }}</th>
                    <td>{{ category.name }}</td>
                    <td>
                        <RouterLink :to="{ path: '/categories/' + category.id + '/edit' }" class="btn btn-warning">編輯
                        </RouterLink>
                        <button type="button" @click="deleteCategory(category.id)" class="btn btn-danger">刪除</button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="6">正在載入中...</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "categories",
    data() {
        return {
            categories: [],
        };
    },
    mounted() {
        this.getCategories();
    },
    methods: {
        getCategories() {
            axios.get("http://127.0.0.1:8000/api/categories").then((res) => {
                this.categories = res.data.categories;
                console.log(this.categories);
            });
        },

        deleteCategory(categoryId) {
            if (confirm("你確定要刪除這筆資料嗎？")) {
                console.log(categoryId);
                axios.delete(`http://127.0.0.1:8000/api/categories/${categoryId}/delete`).then(res => {
                    alert(res.data.message);
                    this.getCategories();
                })
                    .catch(function (error) {
                        if (error.response) {
                            if (error.response.status == 404) {
                                alert(error.response.data.message);
                            }
                        }
                    });
            }
        },
    },
};
</script>

<template>
    <div class="container mt-5 mb-5">
        <RouterLink to="/articles/create" class="btn btn-primary">新增</RouterLink>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">標題</th>
                    <th scope="col">連結</th>
                    <th scope="col">分類</th>
                    <th scope="col">標籤</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody v-if="this.articles.length > 0">
                <tr v-for="(article, index) in this.articles" :key="index">
                    <th scope="row">{{ article.id }}</th>
                    <td>{{ article.title }}</td>
                    <td>{{ article.link }}</td>
                    <td>{{ article.category.name }}</td>
                    <td><span v-for="(tag, index) in article.tags" :key="index">{{ tag.name }}&nbsp;</span></td>
                    <td>
                        <RouterLink :to="{ path: '/articles/' + article.id + '/edit' }" class="btn btn-warning">編輯
                        </RouterLink>
                        <button type="button" @click="deleteArticle(article.id)" class="btn btn-danger">刪除</button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="6">正在載入中...</td>
                </tr>
            </tbody>
        </table>
        <v-pagination v-model="page" :pages="pageCount" :range-size="1" active-color="#DCEDFF"
            @update:modelValue="getArticles" />
    </div>
</template>

<script>
import axios from "axios";
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";

export default {
    components: {
        VPagination
    },
    name: "articles",
    data() {
        return {
            articles: [],
            page: 1,
            pageCount: null,
        };
    },
    mounted() {
        this.getArticles();
    },
    methods: {
        getArticles() {
            axios.get("http://127.0.0.1:8000/api/articles?page=" + this.page).then((res) => {
                this.pageCount = res.data.pageCount;
                this.articles = res.data.paginate.data;
                console.log(this.articles);
            });
        },

        deleteArticle(articleId) {
            if (confirm("你確定要刪除這筆資料嗎？")) {
                console.log(articleId);
                axios.delete(`http://127.0.0.1:8000/api/articles/${articleId}/delete`).then(res => {
                    alert(res.data.message);
                    this.getArticles();
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

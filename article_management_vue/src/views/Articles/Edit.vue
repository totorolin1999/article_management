<template>
    <div class="container mt-5">
        <ul class="list-group" v-if="Object.keys(this.errorList).length > 0">
            <li class="list-group-item" v-for="(error, index) in this.errorList" :key="index">{{ error[0] }}</li>
        </ul>
        <form>
            <div class="mb-3">
                <label for="" class="form-label">標題</label>
                <input type="text" v-model="model.article.title" class="form-control">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">連結</label>
                <input type="text" v-model="model.article.link" class="form-control">
            </div>
            <div class="mb-3">
                <select class="form-select" aria-label="Default select example" v-model="model.article.category_id">
                    <option value="">請選擇分類</option>
                    <option v-for="(category, index) in this.categories" :key="index" :value="category.id">{{ category.name
                    }}</option>
                </select>
            </div>
            <div class="mb-3">
                <div class="form-check form-check-inline" v-for="(tag, index) in this.tags" :key="index">
                    <input class="form-check-input" type="checkbox" :id="index" :value="tag.id"
                        v-model="model.article.tag_id">
                    <label class="form-check-label" :for="index">{{ tag.name }}</label>
                </div>
            </div>
            <button type="button" @click="updateArticle" class="btn btn-warning">更新</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
    name: "articleEdit",
    data() {
        return {
            articleId: "",
            errorList: '',
            model: {
                article: {
                    title: '',
                    link: '',
                    category_id: '',
                    tag_id: []
                }
            },
            categories: [],
            tags: []
        }
    },
    mounted() {
        this.articleId = this.$route.params.id;
        this.getArticleData(this.$route.params.id);
        this.getCategories();
        this.getTags();
    },
    methods: {
        getCategories() {
            axios.get("http://127.0.0.1:8000/api/categories").then((res) => {
                this.categories = res.data.categories;
                console.log(this.categories);
            });
        },
        getTags() {
            axios.get("http://127.0.0.1:8000/api/tags").then((res) => {
                this.tags = res.data.tags;
                console.log(this.tags);
            });
        },

        getArticleData(articleId) {

            axios.get(`http://127.0.0.1:8000/api/articles/${articleId}/edit`).then(res => {
                console.log(res.data.article);
                this.model.article = res.data.article;
                this.model.article.tag_id = res.data.article.tags.map(tag => tag.id);
            })
                .catch(function (error) {
                    if (error.response) {
                        if (error.response.status == 404) {
                            alert(error.response.data.message);
                        }
                    }
                });
        },

        updateArticle() {

            var mythis = this;
            axios.put(`http://127.0.0.1:8000/api/articles/${this.articleId}/edit`, this.model.article).then(res => {

                console.log(res.data);
                Swal.fire({
                    icon: 'success',
                    title: res.data.message
                });

                this.errorList = '';
            })
                .catch(function (error) {
                    if (error.response) {
                        if (error.response.status == 422) {
                            mythis.errorList = error.response.data.errors;
                        }
                        if (error.response.status == 404) {
                            alert(error.response.data.message);
                        }
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log("Error", error.message);
                    }

                })
        }
    },
}
</script>
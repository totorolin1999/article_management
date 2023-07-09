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
                    <input class="form-check-input" type="checkbox" :id="index" :value="tag.id" v-model="model.article.tag_id">
                    <label class="form-check-label" :for="index">{{ tag.name }}</label>
                </div>
            </div>
            <button type="button" @click="saveArticle" class="btn btn-primary">儲存</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "articleCreate",
    data() {
        return {
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

        saveArticle() {

            var mythis = this;
            axios.post("http://127.0.0.1:8000/api/articles", this.model.article).then(res => {

                console.log(res.data);
                alert(res.data.message);

                this.model.article = {
                    title: '',
                    link: '',
                    category_id: '',
                    tag_id: []
                }
                this.errorList = '';
            })
                .catch(function (error) {
                    if (error.response) {
                        if (error.response.status == 422) {
                            mythis.errorList = error.response.data.errors;
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
<template>
    <div class="container mt-5">
        <ul class="list-group" v-if="Object.keys(this.errorList).length > 0">
            <li class="list-group-item" v-for="(error, index) in this.errorList" :key="index">{{ error[0] }}</li>
        </ul>
        <form>
            <div class="mb-3">
                <label for="" class="form-label">名稱</label>
                <input type="text" v-model="model.category.name" class="form-control">
            </div>
            <button type="button" @click="updateCategory" class="btn btn-warning">更新</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
    name: "categoryEdit",
    data() {
        return {
            categoryId: "",
            errorList: '',
            model: {
                category: {
                    name: ''
                }
            }
        }
    },
    mounted() {
        this.categoryId = this.$route.params.id;
        this.getCategoryData(this.$route.params.id);
    },
    methods: {

        getCategoryData(categoryId) {

            axios.get(`http://127.0.0.1:8000/api/categories/${categoryId}/edit`).then(res => {
                console.log(res.data.category);
                this.model.category = res.data.category;
            })
                .catch(function (error) {
                    if (error.response) {
                        if (error.response.status == 404) {
                            alert(error.response.data.message);
                        }
                    }
                });
        },

        updateCategory() {

            var mythis = this;
            axios.put(`http://127.0.0.1:8000/api/categories/${this.categoryId}/edit`, this.model.category).then(res => {

                console.log(res.data);
                Swal.fire(res.data.message);

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
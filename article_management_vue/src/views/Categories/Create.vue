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
            <button type="button" @click="saveCategory" class="btn btn-primary">儲存</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "categoryCreate",
    data() {
        return {
            errorList: '',
            model: {
                category: {
                    name: ''
                }
            }
        }
    },
    methods: {

        saveCategory() {

            var mythis = this;
            axios.post("http://127.0.0.1:8000/api/categories", this.model.category).then(res => {

                console.log(res.data);
                alert(res.data.message);

                this.model.category = {
                    name: ''
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
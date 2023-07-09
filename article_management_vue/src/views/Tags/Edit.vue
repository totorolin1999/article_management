<template>
    <div class="container mt-5">
        <ul class="list-group" v-if="Object.keys(this.errorList).length > 0">
            <li class="list-group-item" v-for="(error, index) in this.errorList" :key="index">{{ error[0] }}</li>
        </ul>
        <form>
            <div class="mb-3">
                <label for="" class="form-label">名稱</label>
                <input type="text" v-model="model.tag.name" class="form-control">
            </div>
            <button type="button" @click="updateTag" class="btn btn-warning">更新</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
    name: "tagEdit",
    data() {
        return {
            tagId: "",
            errorList: '',
            model: {
                tag: {
                    name: ''
                }
            }
        }
    },
    mounted() {
        this.tagId = this.$route.params.id;
        this.getTagData(this.$route.params.id);
    },
    methods: {

        getTagData(tagId) {

            axios.get(`http://127.0.0.1:8000/api/tags/${tagId}/edit`).then(res => {
                console.log(res.data.tag);
                this.model.tag = res.data.tag;
            })
                .catch(function (error) {
                    if (error.response) {
                        if (error.response.status == 404) {
                            alert(error.response.data.message);
                        }
                    }
                });
        },

        updateTag() {

            var mythis = this;
            axios.put(`http://127.0.0.1:8000/api/tags/${this.tagId}/edit`, this.model.tag).then(res => {

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
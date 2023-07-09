<template>
    <div class="container mt-5 mb-5">
        <RouterLink to="/tags/create" class="btn btn-primary">新增</RouterLink>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">名稱</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody v-if="this.tags.length > 0">
                <tr v-for="(tag, index) in this.tags" :key="index">
                    <th scope="row">{{ tag.id }}</th>
                    <td>{{ tag.name }}</td>
                    <td>
                        <RouterLink :to="{ path: '/tags/' + tag.id + '/edit' }" class="btn btn-warning">編輯
                        </RouterLink>
                        <button type="button" @click="deleteTag(tag.id)" class="btn btn-danger">刪除</button>
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
    name: "tags",
    data() {
        return {
            tags: [],
        };
    },
    mounted() {
        this.getTags();
    },
    methods: {
        getTags() {
            axios.get("http://127.0.0.1:8000/api/tags").then((res) => {
                this.tags = res.data.tags;
                console.log(this.tags);
            });
        },

        deleteTag(tagId) {
            if (confirm("你確定要刪除這筆資料嗎？")) {
                console.log(tagId);
                axios.delete(`http://127.0.0.1:8000/api/tags/${tagId}/delete`).then(res => {
                    alert(res.data.message);
                    this.getTags();
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

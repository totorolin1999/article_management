import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import ArticleView from "../views/Articles/View.vue";
import ArticleCreate from "../views/Articles/Create.vue";
import ArticleEdit from "../views/Articles/Edit.vue";
import CategoryView from "../views/Categories/View.vue";
import CategoryCreate from "../views/Categories/Create.vue";
import CategoryEdit from "../views/Categories/Edit.vue";
import TagView from "../views/Tags/View.vue";
import TagCreate from "../views/Tags/Create.vue";
import TagEdit from "../views/Tags/Edit.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/about",
      name: "about",
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import("../views/AboutView.vue"),
    },
    {
      path: "/articles",
      name: "articles",
      component: ArticleView,
    },
    {
      path: "/articles/create",
      name: "articleCreate",
      component: ArticleCreate,
    },
    {
      path: "/articles/:id/edit",
      name: "articleEdit",
      component: ArticleEdit,
    },
    {
      path: "/categories",
      name: "categories",
      component: CategoryView,
    },
    {
      path: "/categories/create",
      name: "categoryCreate",
      component: CategoryCreate,
    },
    {
      path: "/categories/:id/edit",
      name: "categoryEdit",
      component: CategoryEdit,
    },
    {
      path: "/tags",
      name: "tags",
      component: TagView,
    },
    {
      path: "/tags/create",
      name: "tagCreate",
      component: TagCreate,
    },
    {
      path: "/tags/:id/edit",
      name: "tagEdit",
      component: TagEdit,
    },
  ],
});

export default router;

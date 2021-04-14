import Axios from "axios";

export default {
    state: {
        postData: [],
        categoriesData: [],
    },
    getters: {
        categories(state) {
            return state.categoriesData;
        },
        post(state) {
            return state.postData;
        }
    },
    actions: {
        getCategories(data) {
            axios.get("categories").then((result) => {
                data.commit("categories", result.data.categories);
            }).catch((err) => {
                console.log(err);
            });
        },
        getPost(data) {
            axios.get("get-post").then((result) => {
                data.commit("post", result.data.post);
            }).catch((err) => {
                console.log(err);
            });
        }
    },

    mutations: {
        categories(state, data) {
            return state.categoriesData = data;
        },
        post(state, data) {
            return state.postData = data;
        }
    },
}
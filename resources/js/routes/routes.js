
import home from '../components/backend/home';
//Categories backend
import categories from '../components/backend/category/manage';
import AddCategories from '../components/backend/category/create';
import EditCategories from '../components/backend/category/update';

//Categories backend
import post from '../components/backend/post/manage';
import AddPost from '../components/backend/post/create';
import EditPost from '../components/backend/post/update';

export const routes = [

    { path: '/home', component: home },
    { path: '/categories', component: categories },
    { path: '/add-category', component: AddCategories },
    { path: '/edit-category/:slug', component: EditCategories },
    { path: '/post', component: post },
    { path: '/add-post', component: AddPost },
    { path: '/edit-post/:slug', component: EditPost },
];
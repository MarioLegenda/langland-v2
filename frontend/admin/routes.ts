import {Menu} from "./Menu";
import {NewLesson} from './NewLesson';

export const routes = [
    { path: '/admin', component: Menu},
    { path: '/admin/lessons/new', component: NewLesson},
];
import {LandingPage} from "./LandingPage";
import {Guide} from "./Guide";
import {SignUp} from "./SignUp";
import {SignIn} from "./SignIn";
import {LanglandAppRootIndex} from "../App/LanglandAppRootIndex";

export const routes = [
    { path: '/', component: LandingPage},
    { path: '/guide', component: Guide},
    { path: '/sign-up', component: SignUp},
    { path: '/sign-in', component: SignIn},
    { path: '/langland', component: LanglandAppRootIndex},
];
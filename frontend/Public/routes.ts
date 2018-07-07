import {LandingPage} from "./LandingPage";
import {Guide} from "./Guide";
import {SignUp} from "./SignUp";
import {SignIn} from "./SignIn";

export const routes = [
    { path: '/', component: LandingPage},
    { path: '/guide', component: Guide},
    { path: '/sign-up', component: SignUp},
    { path: '/sign-in', component: SignIn},
];
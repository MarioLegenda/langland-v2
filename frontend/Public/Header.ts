const Navigation = {
    template: `<div class="nav-wrapper">
                   <nav>
                       <router-link to="/guide">GUIDE</router-link>
                       <a href="">ABOUT</a>
                   </nav>
               </div>`,
};

const UserActions = {
    template: `<div class="user-actions-wrapper">
                   <nav>
                       <a href="">Sign in</a>
                       <a href="">Sign up</a>
                   </nav>
               </div>`
};

export const Header = {
    template: `<header id="main_header" class="header">
                  <div class="logo">
                      <router-link to="/" class="logo-header">Langland</router-link>
                  </div>
                  
                  <UserActions></UserActions>
                  <Navigation></Navigation>
              </header>`,
    components: {
        Navigation,
        UserActions
    }
};

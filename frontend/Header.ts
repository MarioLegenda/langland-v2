const Navigation = {
    template: `<div class="nav-wrapper">
                   <nav>
                       <a href="">GUIDE</a>
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
                      <h1>Langland</h1>
                  </div>
                  
                  <UserActions></UserActions>
                  <Navigation></Navigation>
              </header>`,
    components: {
        Navigation,
        UserActions
    }
};

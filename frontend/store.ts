export const store = {
    debug: true,
    state: {
        user: null
    },
    addUser(user) {
        if (this.debug) console.log(`Added user to store`);

        this.state.user = user;
    }
};
import {IUser} from "../DataSource/Models";

export const store = {
    debug: true,
    state: {
        user: null
    },
    addUser(user: IUser) {
        if (this.debug) console.log(`Added user with id ${user.id} to store`);

        this.state.user = user;
    },

    get user(): IUser {
        return this.state.user;
    }
};
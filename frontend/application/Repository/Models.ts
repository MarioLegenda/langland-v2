export interface ILocale {
    readonly id: number,
    readonly name: string,
    readonly default: boolean,
    readonly createdAt: string,
    readonly updatedAt: string,
}

export interface IUser {
    readonly id: number,
    readonly name: string,
    readonly lastname: string,
    readonly username: string,
    readonly email: string,
    readonly enabled: boolean,
    readonly locale: ILocale,
    readonly createdAt: string,
    readonly updatedAt: string,
}

export class Locale implements ILocale {
    readonly id: number;
    readonly name: string;
    readonly default: boolean;
    readonly createdAt: string;
    readonly updatedAt: string;

    constructor(locale: ILocale) {
        this.id = locale.id;
        this.name = locale.name;
        this.default = locale.default;
        this.createdAt = locale.createdAt;
        this.updatedAt = locale.updatedAt;
    }
}

export class User implements IUser {
    readonly id: number;
    readonly name: string;
    readonly lastname: string;
    readonly username: string;
    readonly email: string;
    readonly enabled: boolean;
    readonly locale: ILocale;
    readonly createdAt: string;
    readonly updatedAt: string;

    constructor(user: IUser) {
        this.id = user.id;
        this.name = user.name;
        this.lastname = user.lastname;
        this.username = user.username;
        this.email = user.email;
        this.enabled = user.enabled;
        this.locale = new Locale(user.locale);
        this.createdAt = user.createdAt;
        this.updatedAt = user.updatedAt;
    }
}
import {IUserRepository, IResponse, IRequest, IRepository, Method, InternalType, ILanguageRepository} from "./Contract";
import {sources} from "./Context";
import {IUser, User} from "./Models";

function httpError(response) {
    if (response.status < 200 || response.status > 299) {
        throw new Error(`An error occurred. 200 status code not given. Status code: ${response.status}. Status text: ${response.statusText}`);
    }

    return response;
}

function toJson(response): Promise<object> {
    return response.json();
}

export class Response implements IResponse {
    properties: string[];
    method: string;
    type: string;
    statusCode: number;
    messages: string[];
    cacheKey: any;

    constructor(response: IResponse) {
        this.properties = response.properties;
        this.method = response.method;
        this.type = response.type;
        this.statusCode = response.statusCode;
        this.messages = response.messages;
        this.cacheKey = response.cacheKey;
    }
}

export class Request implements IRequest {
    source: string;
    internalType: string;
    method: string;
    data: object;
    name: string;

    constructor(request: IRequest) {
        this.source = request.source;
        this.internalType = request.internalType;
        this.method = request.method;
        this.data = request.data;
        this.name = request.name;
    }
}

export class UserRepository implements IUserRepository {
    read(success: any, request?: IRequest): void {
        if (!(success instanceof Function)) {
            throw new Error(`First argument to create() has to be a function`);
        }

        if (typeof request === 'undefined') {
            request = new Request({
                source: sources.app_get_logged_in_user,
                internalType: InternalType.FETCH,
                method: Method.GET,
                data: {},
                name: 'get_user'
            });
        }

        let headers: Headers = new Headers();
        headers.append('Cache-Control', 'no-store');
        headers.append('Pragma', 'no-cache');

        fetch(request.source, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(httpError)
            .then(toJson)
            .then(success)
    }

    async asyncRead(success?: any, request?: IRequest) {
        if (typeof request === 'undefined') {
            request = new Request({
                source: sources.app_get_logged_in_user,
                internalType: 'fetch',
                method: 'GET',
                data: {},
                name: 'get_user'
            });
        }

        const response: any = await fetch(request.source, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        httpError(response);

        success(await response.json());
    }
}

export class LanguageRepository implements ILanguageRepository{
    read(success: any, request?: IRequest): void {
        if (!(success instanceof Function)) {
            throw new Error(`First argument to create() has to be a function`);
        }

        if (typeof request === 'undefined') {
            request = new Request({
                source: sources.app_get_logged_in_user,
                internalType: InternalType.FETCH,
                method: Method.GET,
                data: {},
                name: 'get_languages'
            });
        }

        fetch(request.source, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(httpError)
            .then(toJson)
            .then(success)
    }

    async asyncRead(success?: any, request?: IRequest) {
        if (typeof request === 'undefined') {
            request = new Request({
                source: sources.app_get_logged_in_user,
                internalType: 'fetch',
                method: 'GET',
                data: {},
                name: 'get_languages'
            });
        }

        const response: any = await fetch(request.source, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        httpError(response);

        success(await response.json());
    }
}

export class RepositoryFactory {
    private static _instance: RepositoryFactory;

    private constructor() {}

    static get getInstance(): RepositoryFactory {
        if (RepositoryFactory.getInstance instanceof RepositoryFactory) {
            return RepositoryFactory.getInstance;
        }

        RepositoryFactory._instance = new RepositoryFactory();

        return RepositoryFactory.getInstance;
    }

    public static create(key: string): IRepository {
        switch (key) {
            case 'user':
                return new UserRepository();
        }

        throw new Error(`Repository ${key} not found`);
    }
}
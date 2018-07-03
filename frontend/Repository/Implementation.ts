import {ILanguageRepository, IResponse, IRequest} from "./Contract";

class Response implements IResponse {
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

class Request implements IRequest {
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

export class UserRepository implements ILanguageRepository {
    create(request: IRequest): IResponse {
        // the place to fetch the data from the server
        return new Response({
            properties: [],
            method: 'GET',
            type: 'creation',
            statusCode: 201,
            messages: [],
            cacheKey: null
        });
    }

    read(request: IRequest): IResponse {
        return new Response({
            properties: [],
            method: 'GET',
            type: 'creation',
            statusCode: 201,
            messages: [],
            cacheKey: null
        });
    }

    update(request: IRequest): IResponse {
        return new Response({
            properties: [],
            method: 'GET',
            type: 'creation',
            statusCode: 201,
            messages: [],
            cacheKey: null
        });
    }
}
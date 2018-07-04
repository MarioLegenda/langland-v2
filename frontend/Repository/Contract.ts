interface IResponseResource {
    data: object
}

interface IResponseCollection {
    totalItems: number,
    data: object
}

export interface IRepository {
    read(success: Function, context?: IRequest): void,
    asyncRead(context?: IRequest): Promise<object>;
}

export enum Method {
    GET = 'GET',
    PUT = 'PUT',
    POST = 'POST'
}

export enum InternalType {
    FETCH = 'fetch',
    CREATE = 'create',
    MODIFY = 'modify'
}

export interface IResponse {
    properties: string[],
    method: string,
    type: string,
    statusCode: number,
    messages: string[],
    cacheKey: any,
    resource?: IResponseResource,
    collection?: IResponseCollection
}

export interface IRequest {
    source: string,
    internalType: string,
    method: string,
    data: object,
    name: string
}

export interface IUserRepository extends IRepository {}
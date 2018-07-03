interface IRepository {
    create(context: IRequest): IResponse,
    read(context: IRequest): IResponse,
    update(context: IRequest): IResponse
}

interface IResponseResource {
    data: object
}

interface IResponseCollection {
    totalItems: number,
    data: object
}

export enum Method {
    GET = 'GET',
    PUT = 'PUT',
    POST = 'POST'
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

export interface ILanguageRepository extends IRepository {}
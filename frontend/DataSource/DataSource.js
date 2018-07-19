class BaseRepository {
    makeDefaultRequest(request, success, failure) {
        $.ajax({
            method: request.options.method,
            url: request.options.route,
            data: {
                http: request.toObject()
            },
            success: success
        });
    }
}

class LanguageRepository extends BaseRepository{
    constructor() {
        super();
    }

    read(request, success, failure) {
        this.makeDefaultRequest(request, success, failure);
    }
}

class LocaleRepository extends BaseRepository{
    constructor() {
        super();
    }

    read(request, success, failure) {
        this.makeDefaultRequest(request, success, failure);
    }
}

class Factory {
    create(repository) {
        this.repositories = {};

        switch (repository) {
            case 'language':
                if (!this.repositories.hasOwnProperty(repository)) {
                    this.repositories[repository] = new LanguageRepository();
                }

                return this.repositories[repository];

            case 'locale':
                if (!this.repositories.hasOwnProperty(repository)) {
                    this.repositories[repository] = new LocaleRepository();
                }

                return this.repositories[repository];
        }

        throw new Error(`Repository ${repository} not found`);
    }
}

export const RepositoryFactory = new Factory();

export const Method = {
    GET: 'GET',
    POST: 'POST',
    PATCH: 'PATCH',
    PUT: 'PUT',
};

export const InternalType = {
    VIEW: 'view',
    PAGINATED_INTERNALIZED_VIEW: 'paginated_internalized_view',
    PAGINATED_VIEW: 'paginated_view',
};

export class Request {
    constructor(...options) {
        this.options = options[0];
    }

    toObject() {
        return this.options;
    }
}
class LanguageRepository {
    read(request, success, failure) {
        $.ajax({
            method: request.options.method,
            url: request.options.route,
            data: {
                http: request.toObject()
            },
            success: success
        });
    }

    asyncRead() {

    }
}

class Factory {
    create(repository) {
        this.repositories = {};

        switch (repository) {
            case repository:
                if (!this.repositories.hasOwnProperty(repository)) {
                    this.repositories[repository] = new LanguageRepository();
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
};

export class Request {
    constructor(...options) {
        this.options = options[0];
    }

    toObject() {
        return this.options;
    }
}
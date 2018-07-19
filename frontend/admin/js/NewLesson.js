import {RepositoryFactory, Method, InternalType, Request} from "../../DataSource/DataSource";
import {sources} from '../../DataSource/sources';

export const NewLesson = {
    data: function() {
        return {
            model: {
                name: '',
                language: '',
                locale: ''
            },
            form: {
                languages: [],
                locales: [],
            }
        }
    },
    beforeCreate: function() {
        const languageRepository = RepositoryFactory.create('language');
        const localeRepository = RepositoryFactory.create('locale');

        localeRepository.read(new Request({
            baseUrl: sources.baseUrl,
            route: sources.routes.app_get_locales,
            method: Method.POST,
            internalType: InternalType.PAGINATED_VIEW,
            data: {
                offset: 0,
                limit: 10,
                locale: 'en',
            },
            name: 'locale_list',
        }), (data) => {
            this.form.locales = data.collection.data;
        });

        languageRepository.read(new Request({
            baseUrl: sources.baseUrl,
            route: sources.routes.app_get_languages,
            method: Method.POST,
            internalType: InternalType.PAGINATED_INTERNALIZED_VIEW,
            data: {
                offset: 0,
                limit: 10,
                locale: 'en',
            },
            name: 'language_list'
        }), (data) => {
            this.form.languages = data.collection.data;
        });
    },
    template: `
        <div>
            <div class="form-group">
                <label>Name</label>
                <input v-model="model.name" type="text" class="form-control" placeholder="Lesson name">
            </div>
            
            <div class="form-group">
                <label>Language</label>
                    <select v-model="model.language" class="form-control">
                      <option disabled value="">Please select one</option>
                      <option v-for="language in form.languages">{{ language.name }}</option>
                    </select>
            </div>
            
            <div class="form-group">
                <label>Locale</label>
                    <select v-model="model.locale" class="form-control">
                      <option disabled value="">Please select one</option>
                      <option v-for="locale in form.locales">{{ locale.name }}</option>
                    </select>
            </div>
        </div>
    `
};
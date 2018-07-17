export const NewLesson = {
    data: function() {
        return {
            name: '',
            language: '',
            locale: ''
        }
    },
    beforeCreate: function() {

    },
    template: `
        <div>
            <div class="form-group">
                <label>Name</label>
                <input v-model="name" type="text" class="form-control" placeholder="Lesson name">
            </div>
            
            <div class="form-group">
                <label>Language</label>
                    <select v-model="language" class="form-control">
                      <option disabled value="">Please select one</option>
                      <option>French</option>
                      <option>English</option>
                      <option>Spanish</option>
                    </select>
            </div>
            
            <div class="form-group">
                <label>Locale</label>
                    <select v-model="language" class="form-control">
                      <option disabled value="">Please select one</option>
                      <option>en</option>
                      <option>fr</option>
                      <option>sp</option>
                    </select>
            </div>
        </div>
    `
};
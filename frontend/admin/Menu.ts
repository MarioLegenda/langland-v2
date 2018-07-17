export const Menu = {
    template: `
            <div class="card text-white bg-primary mb-3" style="max-width: 20rem;">
            <p class="bs-component">
                <div class="card-header">Lessons</div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary">View</button>
                    <router-link to="/admin/lessons/new" class="btn btn-primary">Create new</router-link>
                </div>
                </p>
              </div>
    `
}
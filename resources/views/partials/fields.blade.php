<div class="container" id="fields" v-show="showTab == 'fields'">
    <div class="row">
        <div class="col-12 options mt-3">
            <button class="btn btn-sm btn-warning"
                @click="showModal('addField')">
                Add Field
            </button>
        </div>
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="border-top-0" scope="col">#</th>
                        <th class="border-top-0" scope="col">Title</th>
                        <th class="border-top-0" scope="col">Type</th>
                        <th class="border-top-0" scope="col">Edit</th>
                        <th class="border-top-0" scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="field in fields">
                        <tr>
                            <th scope="row">@{{ field.id }}</th>
                            <td>@{{ field.title }}</td>
                            <td>@{{ field.type }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" :id="'loadField' + field.id"
                                    @click="showModal('editField'); loadField(field.id);">
                                    Edit
                                </button>
                            </td>
                            <td>
                                <form :action="'/api/fields/' + field.id" method="POST" class="form" @submit.prevent="deleteField">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="field_id" :value="field.id">
                                    <input type="hidden" name="field_title" :value="field.title">
                                    <button type="submit" class="btn btn-sm btn-danger" :id="'deleteField' + field.id">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
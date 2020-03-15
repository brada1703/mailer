<div class="modal fade" id="editSubscriber" tabindex="-1" role="dialog" aria-labelledby="editSubscriberTitle" aria-modal="true"
    :class="{ 'show d-block' : modal == 'editSubscriber' }" @click="closeModal($event.target)">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form :action="'/api/subscribers/' + editableSubscriber.id" method="POST" class="form" id="editSubscriberForm" @submit.prevent="editSubscriber">
                @csrf
                @method('PATCH')
                <template v-for="field in fields">
                    <input type="hidden" :name="'field_' + field.id" :id="'field_' + field.id" v-if="field.type == 'boolean'"
                        :value="editableFieldValues.filter(obj=>obj.field_id == field.id)[0] ?
                            editableFieldValues.filter(obj=>obj.field_id == field.id)[0].value : false">
                </template>
                <input type="hidden" name="editableSubscriberId" :value="editableSubscriber.id">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubscriberTitle">Edit Subscriber</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="showModal('')">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body container">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name" placeholder="First Name"
                                    :value="editableSubscriber.first_name" :class="{ 'border-danger' : errors.includes('first_name') }">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Last Name"
                                    :value="editableSubscriber.last_name" :class="{ 'border-danger' : errors.includes('last_name') }">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email"
                                    :value="editableSubscriber.email" :class="{ 'border-danger' : errors.includes('email') }">
                            </div>
                        </div>
                        <div class="col-12" v-for="field in fields">
                            <div class="form-group">
                                <label :for="'field_' + field.id">@{{ field.title }}</label>
                                <input class="form-control" type="date" value="" v-if="field.type == 'date'"
                                    :name="'field_' + field.id" :placeholder="field.title"
                                    :value="editableFieldValues.filter(obj=>obj.field_id == field.id)[0] ?
                                        editableFieldValues.filter(obj=>obj.field_id == field.id)[0].value : ''">
                                <input class="form-control" type="number" value="" v-if="field.type == 'number'"
                                    :name="'field_' + field.id" :placeholder="field.title"
                                    :value="editableFieldValues.filter(obj=>obj.field_id == field.id)[0] ?
                                        editableFieldValues.filter(obj=>obj.field_id == field.id)[0].value : ''">
                                <input class="form-control" type="text" value="" v-if="field.type == 'string'"
                                    :name="'field_' + field.id" :placeholder="field.title"
                                    :value="editableFieldValues.filter(obj=>obj.field_id == field.id)[0] ?
                                        editableFieldValues.filter(obj=>obj.field_id == field.id)[0].value : ''">
                                <template v-if="field.type == 'boolean'">
                                    <template v-if="editableFieldValues.filter(obj=>obj.field_id == field.id)[0] &&
                                        editableFieldValues.filter(obj=>obj.field_id == field.id)[0].value == 'true'">
                                        <input class="form-control" type="checkbox" :data="'field_' + field.id" @click="check($event)" checked>
                                    </template>
                                    <template v-else>
                                        <input class="form-control" type="checkbox" :data="'field_' + field.id" @click="check($event)">
                                    </template>
                                </template>
                            </div>
                        </div>
                        <div class="col-12" v-if="errors.includes('field_id')">
                            <p class="text-danger text-center">
                                A field is no longer valid.<br>Please refresh the browser and try again.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" :id="'editSubscriberButton' + editableSubscriber.id">
                        Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click.prevent="showModal('')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
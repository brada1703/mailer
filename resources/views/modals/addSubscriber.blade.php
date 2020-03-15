<div class="modal fade" id="addSubscriber" tabindex="-1" role="dialog" aria-labelledby="addSubscriberTitle" aria-modal="true"
    :class="{ 'show d-block' : modal == 'addSubscriber' }" @click="closeModal($event.target)">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="/api/subscribers" method="POST" class="form" id="subscriberForm" @submit.prevent="addSubscriber">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubscriberTitle">Add New Subscriber</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        @click.prevent="showModal('')">
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
                                    :class="{ 'border-danger' : errors.includes('first_name') }">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Last Name"
                                    :class="{ 'border-danger' : errors.includes('last_name') }">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email"
                                    :class="{ 'border-danger' : errors.includes('email') }">
                            </div>
                        </div>
                        <div class="col-12" v-for="field in fields">
                            <div class="form-group">
                                <label :for="'field_' + field.id" class="text-capitalize">@{{ field.title }}</label>
                                <input class="form-control" type="date" value=""
                                    v-if="field.type == 'date'" :name="'field_' + field.id" :placeholder="field.title"
                                    :class="{ 'border-danger' : errors.includes('field_' + field.id) }">
                                <input class="form-control" type="number" value=""
                                    v-if="field.type == 'number'" :name="'field_' + field.id" :placeholder="field.title"
                                    :class="{ 'border-danger' : errors.includes('field_' + field.id) }">
                                <input class="form-control" type="text" value=""
                                    v-if="field.type == 'string'" :name="'field_' + field.id" :placeholder="field.title"
                                    :class="{ 'border-danger' : errors.includes('field_' + field.id) }">
                                <input class="form-control" type="checkbox" value="true"
                                    v-if="field.type == 'boolean'" :name="'field_' + field.id" :placeholder="field.title"
                                    :class="{ 'border-danger' : errors.includes('field_' + field.id) }">
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
                    <button type="submit" class="btn btn-success" id="addSubscriberButton">
                        Create
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click.prevent="showModal('')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
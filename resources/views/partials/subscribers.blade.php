<div class="container" id="subscribers" v-show="showTab == 'subscribers'">
    <div class="row">
        <div class="col-12 options mt-3">
            <button class="btn btn-sm btn-warning"
                @click="showModal('addSubscriber')">
                Add Subscriber
            </button>
        </div>
        <div class="col-12 max-w-100 overflow-auto">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="border-top-0" scope="col">#</th>
                        <th class="border-top-0" scope="col">Email</th>
                        <th class="border-top-0" scope="col">First Name</th>
                        <th class="border-top-0" scope="col">Last Name</th>
                        <th class="border-top-0" scope="col">State</th>
                        <template v-for="field in fields">
                            <th class="border-top-0 text-uppercase" scope="col">
                                @{{ field.title }}
                            </th>
                        </template>
                        <th class="border-top-0" scope="col">Edit</th>
                        <th class="border-top-0" scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="subscriber in subscribers">
                        <tr>
                        <th scope="row">@{{ subscriber.id }}</th>
                        <td>@{{ subscriber.email }}</td>
                        <td>@{{ subscriber.first_name }}</td>
                        <td>@{{ subscriber.last_name }}</td>
                        <td>
                            <span class="text-capitalize" :class="{
                                    'badge badge-secondary' : subscriber.state == 'unconfirmed',
                                    'badge badge-success' : subscriber.state == 'active',
                                    'badge badge-danger' : subscriber.state == 'junk',
                                    'badge badge-warning' : subscriber.state == 'unsubscribed',
                                    'badge badge-dark' : subscriber.state == 'bounced'
                                }">
                                @{{ subscriber.state }}
                            </span>
                        </td>
                        <template v-for="field in fields">
                            <td>
                                <template v-for="fieldValue in fieldValues">
                                    <span v-if="fieldValue.subscriber_id == subscriber.id && fieldValue.field_id == field.id">
                                        @{{ fieldValue.value }}
                                    </span>
                                </template>
                            </td>
                        </template>
                        <td>
                            <button class="btn btn-sm btn-primary" :id="'loadSubscriber' + subscriber.id"
                                @click="showModal('editSubscriber'); loadSubscriber(subscriber.id);">
                                Edit
                            </button>
                        </td>
                        <td>
                            <form :action="'/api/subscribers/' + subscriber.id" method="POST" class="form" @submit.prevent="deleteSubscriber">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="subscriber_id" :value="subscriber.id">
                                <input type="hidden" name="subscriber_email" :value="subscriber.email">
                                <button type="submit" class="btn btn-sm btn-danger" :id="'deleteSubscriber' + subscriber.id">
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
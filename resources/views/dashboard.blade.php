<!DOCTYPE html>
<html lang="en-CA">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
        <link rel="shortcut icon" type="image/ico" href="/favicon.ico"/>
        <title>Mailer</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700">
        <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
    </head>
    <body>
        <div id="app">
            <header class="py-4 mb-4">
                <div class="container d-flex align-items-center">
                    <img src="dashboard.png" alt="">
                    <h1 class="text-center m-0">Dashboard</h1>
                </div>
            </header>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link" href="#!"
                                    :class="{ 'active' : showTab == 'subscribers' }" @click.prevent="show('subscribers')">
                                    Subscribers
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"
                                    :class="{ 'active' : showTab == 'fields' }" @click.prevent="show('fields')">
                                    Fields
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
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
                                            <label :for="'field_' + field.id">@{{ field.title }}</label>
                                            <input class="form-control" type="date" value=""
                                                v-if="field.type == 'date'" :name="'field_' + field.id" :placeholder="field.title">
                                            <input class="form-control" type="number" value=""
                                                v-if="field.type == 'number'" :name="'field_' + field.id" :placeholder="field.title">
                                            <input class="form-control" type="text" value=""
                                                v-if="field.type == 'string'" :name="'field_' + field.id" :placeholder="field.title">
                                            <input class="form-control" type="checkbox" value="true"
                                                v-if="field.type == 'boolean'" :name="'field_' + field.id" :placeholder="field.title">
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
            <div class="modal fade" id="addField" tabindex="-1" role="dialog" aria-labelledby="addFieldTitle" aria-modal="true"
                :class="{ 'show d-block' : modal == 'addField' }" @click="closeModal($event.target)">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="/api/fields" method="POST" class="form" id="fieldForm" @submit.prevent="addField">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="addFieldTitle">Add New Field</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="showModal('')">
                                    <span aria-hidden="true">
                                        &times;
                                    </span>
                                </button>
                            </div>
                            <div class="modal-body container">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Field Title</label>
                                            <input type="text" class="form-control" name="title" placeholder="Field Title"
                                                :class="{ 'border-danger' : errors.includes('title') }">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="type">Field Type</label>
                                            <select class="form-control" name="type" :class="{ 'border-danger' : errors.includes('type') }">
                                                <option value="" selected>Field Type</option>
                                                <option value="date">Date</option>
                                                <option value="number">Number</option>
                                                <option value="string">String</option>
                                                <option value="boolean">Boolean</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" id="addFieldButton">
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
            <div class="modal fade" id="editField" tabindex="-1" role="dialog" aria-labelledby="editFieldTitle" aria-modal="true"
                :class="{ 'show d-block' : modal == 'editField' }" @click="closeModal($event.target)">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form :action="'/api/fields/' + editableField.id" method="POST" class="form" id="editFieldForm" @submit.prevent="editField">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="editableFieldId" :value="editableField.id">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editFieldTitle">Edit Field</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="showModal('')">
                                    <span aria-hidden="true">
                                        &times;
                                    </span>
                                </button>
                            </div>
                            <div class="modal-body container">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="title">Field Title</label>
                                            <input type="text" class="form-control" name="title" placeholder="Field Title"
                                                :value="editableField.title" :class="{ 'border-danger' : errors.includes('title') }">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="type">Field Type</label>
                                            <select class="form-control" name="type" :class="{ 'border-danger' : errors.includes('type') }">
                                                <option value="" :selected="editableField.type == ''">Field Type</option>
                                                <option value="date" :selected="editableField.type == 'date'">Date</option>
                                                <option value="number" :selected="editableField.type == 'number'">Number</option>
                                                <option value="string" :selected="editableField.type == 'string'">String</option>
                                                <option value="boolean" :selected="editableField.type == 'boolean'">Boolean</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" :id="'editFieldButton' + editableField.id">
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
            <div class="modal-backdrop d-none" :class="{ 'show fade d-block' : modal }"></div>
        </div>
        <script src="{{ mix('js/app.js')}}"></script>
    </body>
</html>
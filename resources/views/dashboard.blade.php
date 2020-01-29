<!DOCTYPE html>
<html lang="en-CA">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
        <link rel="shortcut icon" type="image/ico" href="/favicon.ico"/>

        <title>Mailer</title>

        <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">

    </head>
    <body>
        <div id="app">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p class="text-danger">Test</p>
                        <ul id="example-1">
                            <li v-for="subscriber in subscribers">
                                @{{ subscriber.email }}
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
            <p class="text-center title mt-4">Mailer Dashboard</p>
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
                            @click="showModal('subscribers')">
                            Add Subscriber
                        </button>
                    </div>
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="border-top-0" scope="col">#</th>
                                    <th class="border-top-0" scope="col">Email</th>
                                    <th class="border-top-0" scope="col">First Name</th>
                                    <th class="border-top-0" scope="col">Last Name</th>
                                    <th class="border-top-0" scope="col">State</th>
                                    @foreach($fields as $field)
                                        <th class="border-top-0 text-uppercase" scope="col">
                                            {{ $field->title }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscribers as $subscriber)
                                <tr>
                                    <th scope="row">{{ $subscriber->id }}</th>
                                    <td>{{ $subscriber->email }}</td>
                                    <td>{{ $subscriber->first_name }}</td>
                                    <td>{{ $subscriber->last_name }}</td>
                                    <td>{{ $subscriber->state }}</td>
                                    @foreach($fields as $field)
                                        <td>
                                            @if($fieldvalues->where('subscriber_id', $subscriber->id)->where('field_id', $field->id)->count())
                                                {{ $fieldvalues->where('subscriber_id', $subscriber->id)->where('field_id', $field->id)->first()->value }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="container" id="fields" v-show="showTab == 'fields'">
                <div class="row">
                    <div class="col-12 options mt-3">
                        <button class="btn btn-sm btn-warning"
                            @click="showModal('fields')">
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
                                    <th class="border-top-0" scope="col">Tag</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fields as $field)
                                <tr>
                                    <th scope="row">{{ $field->id }}</th>
                                    <td>{{ $field->title }}</td>
                                    <td>{{ $field->type }}</td>
                                    <td>{${{ $field->title }}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addSubscriber" tabindex="-1" role="dialog"
                aria-labelledby="addSubscriberTitle" aria-modal="true"
                :class="{ 'show d-block' : modal == 'subscribers' }"
                @click="closeModal($event.target)">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="/subscribers" method="POST" class="form" @submit.prevent="addSubscriber">
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
                                    @foreach($fields as $field)
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="field_{{ $field->id }}">{{ ucfirst($field->title) }}</label>
                                                <input class="form-control" name="field_{{ $field->id }}_{{ $field->type }}" placeholder="{{ ucfirst($field->title) }}"
                                                    @switch($field->type)
                                                        @case('date') type="date"
                                                        @case('number') type="number"
                                                        @case('string') type="text"
                                                        @case('boolean') type="checkbox"
                                                        @default type="text"
                                                    @endswitch>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" id="addSubscriberButton">
                                    Create
                                </button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    @click.prevent="showModal('')">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addField" tabindex="-1" role="dialog"
                aria-labelledby="addFieldTitle" aria-modal="true"
                :class="{ 'show d-block' : modal == 'fields' }"
                @click="closeModal($event.target)">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="/fields" method="POST" class="form" @submit.prevent="addField">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="addFieldTitle">Add New Field</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    @click.prevent="showModal('')">
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
                                            <select class="form-control" name="type"
                                                :class="{ 'border-danger' : errors.includes('type') }">
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
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    @click.prevent="showModal('')">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop d-none"
                :class="{ 'show fade d-block' : modal }">
            </div>
        </div>
        <script src="{{ mix('js/app.js')}}"></script>
    </body>
</html>
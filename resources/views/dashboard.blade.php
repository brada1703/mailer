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
            <div class="container" id="subscribers" v-if="showTab == 'subscribers'">
                <div class="row">
                    <div class="col-12 options mt-3">
                        <button class="btn btn-sm btn-warning">Add Subscriber</button>
                        <button class="btn btn-sm btn-outline-primary float-right">Export</button>
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
                                                {{ $fieldvalues->where('subscriber_id', 1)->where('field_id', $field->id)->first()->value }}
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
            <div class="container" id="fields" v-if="showTab == 'fields'">
                <div class="row">
                    <div class="col-12 options mt-3">
                        <button class="btn btn-sm btn-warning">Add Field</button>
                        <button class="btn btn-sm btn-outline-primary float-right">Export</button>
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
        </div>
        <script src="{{ mix('js/app.js')}}"></script>
    </body>
</html>

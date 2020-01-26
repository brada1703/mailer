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
                                <a class="nav-link active" href="#">Subscribers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Fields</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container" id="subscribers">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="border-top-0" scope="col">#</th>
                                    <th class="border-top-0" scope="col">Email</th>
                                    <th class="border-top-0" scope="col">First Name</th>
                                    <th class="border-top-0" scope="col">Last Name</th>
                                    <th class="border-top-0" scope="col">State</th>
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

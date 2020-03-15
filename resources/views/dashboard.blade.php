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
            @include('partials/subscribers')
            @include('partials/fields')
            @include('modals/addSubscriber')
            @include('modals/editSubscriber')
            @include('modals/addField')
            @include('modals/editField')
            <div class="modal-backdrop d-none" :class="{ 'show fade d-block' : modal }"></div>
        </div>
        <script src="{{ mix('js/app.js')}}"></script>
    </body>
</html>
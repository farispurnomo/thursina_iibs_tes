<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="description" content="{{ config('app.name') }}"/>
    <meta name="og:title" content="{{ config('app.name') }}"/>
    <meta name="og:url" content="{{ url()->current() }}"/>
    <meta name="og:image" itemprop="image" content="{{ asset('images/logo_long.png') }}"/>
    <meta name="og:image:url" itemprop="image" content="{{ asset('images/logo_long.png') }}"/>
    <meta name="og:image:type" content="image/png"/>
    <meta name="og:type" content="article"/>
    <meta name="og:locale" content="id_ID"/>

    <link rel="shortcut icon" href="{{ asset('/images/logo_short.png') }}" type="image/png"/>
    
    <title>{{ config('app.name') }} @if(isset($pagetitle)) | {{ $pagetitle }} @endif</title>

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-5.3.3/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free-6.1.1-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/animate/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/template/vendor/css/theme-default.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    
    @yield('styles')
</head>
<body class="d-flex bg-light">

    <main class="container">
        <div class="row">
            <div class="col py-5">
                @yield('content')
            </div>
        </div>
    </main>

    <script src="{{ asset('vendor/jquery-3.6.1/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        function initSelect2(class_name, option) {
            let select;
            if (option.route_to == undefined) {
                select = $(class_name).select2({
                    theme: 'bootstrap-5',
                    placeholder: option.placeholder == undefined ?
                        "Select Option" : option.placeholder,
                    allowClear: option.allowClear == undefined ? false : option.allowClear
                });
            } else {
                select = $(class_name).select2({
                    placeholder: option.placeholder == undefined ?
                        "Select Option" : option.placeholder,
                    allowClear: option.allowClear == undefined ? false : option.allowClear,
                    theme: 'bootstrap-5',
                    ajax: {
                        url: option.route_to,
                        dataType: "json",
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term, // search term
                                page: params.page
                            };
                        },
                        processResults: function(data, params) {
                            // parse the results into the format expected by Select2
                            // since we are using custom formatting functions we do not need to
                            // alter the remote JSON data, except to indicate that infinite
                            // scrolling can be used
                            params.page = params.page || 1;

                            return {
                                results: data.items,
                                pagination: {
                                    more: params.page * 30 < data.total_count
                                }
                            };
                        },
                        cache: true
                    },
                    tags: option.tag == undefined || option.tag == false ?
                        false : option.tag,
                    tokeSparator: [","],
                    escapeMarkup: function(markup) {
                        return markup;
                    }, // let our custom formatter work
                    minimumInputLength: option.MininputLength == undefined ?
                        false : option.MininputLength,
                    templateResult: formatResult, // omitted for brevity, see the source of this page
                    templateSelection: formatResult // omitted for brevity, see the source of this page
                });

                function formatResult(result) {
                    return result.text;
                }
            }

            return select;
        };
    </script>

    @yield('scripts')
</body>
</html>
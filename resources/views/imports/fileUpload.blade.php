<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>{{ $title ?? 'Page Title' }}</title>
</head>
<body>


<div>
    <div class="container">

        @if(session('success'))
            <div style="color: green">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div style="color: red">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row align-items-center">
            <div class="col"></div>
            <div class="col">
                <h1 class="mt-5">Test Task</h1>

                <form action="{{ url('/import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-5">
                        <label for="file" class="form-label">Upload file</label>
                        <input class="form-control form-control-sm" required name="file" id="file" type="file" >
                    </div>
                    @error('file') <span class="text-red text-sm mt-1">{{ $message }}</span> @enderror

                    <button type="submit" class="btn btn-sm btn-danger mt-3" >Submit</button>

                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>

</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        <ul>
            {{session('error')}}
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        <ul>
            {{session('success')}}
        </ul>
    </div>
@endif

@if (session('chinhsua'))
    <div class="alert alert-success">
        <ul>
            {{session('chinhsua')}}
        </ul>
    </div>
@endif
@if (session('themmoi'))
    <div class="alert alert-success">
        <ul>
            {{session('themmoi')}}
        </ul>
    </div>
@endif

@if (session('chuacapnhat'))
    <div class="alert alert-warning">
        <ul>
            {{session('chuacapnhat')}}
        </ul>
    </div>
@endif
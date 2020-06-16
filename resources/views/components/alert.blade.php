<div>
    @if(session()->has('message'))
    <!-- <div class="alert alert-success">{{ session()->get('message')}} </div> -->
    <div class="py-4 px-2 bg-green-400">{{ session()->get('message')}} </div>
    {{ session()->forget('message') }}
    @elseif(session()->has('error'))
    <!-- <div class="alert alert-danger">{{ session()->get('error')}} </div> -->
    <div class="py-4 px-2 bg-red-300">{{ session()->get('error')}} </div>
    @endif

    @if ($errors->any())
    <div class="py-2 px-2 bg-red-300">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@extends('layouts.app')  <!-- extend app.blade.php inside layouts/ --> 
<!-- below is a segment named "content" to view in the 'home' page, this segment 
shluld be called from app.blade.php inside the <main> </main> tag to view
-->
@section('content') 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!!!
                </div>

                <div class="card-body">                
                <x-alert/>
                    <form action="/upload" method="POST" enctype="multipart/form-data">
                        @csrf   <!-- this @csrf token handles routes in form -->
                        <input type="file" name="image"/>
                        <input type="submit" value="upload"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
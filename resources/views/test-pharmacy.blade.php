@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Test Route Pharmacy</h1>
    
    <p>Route Name: pharmacy.index</p>
    <p>Route URL: {{ route('pharmacy.index') }}</p>
    
    <hr>
    
    <h2>Test Links:</h2>
    
    <p>
        <a href="{{ route('pharmacy.index') }}" class="btn btn-primary">
            Link menggunakan route() helper
        </a>
    </p>
    
    <p>
        <a href="/pharmacy" class="btn btn-success">
            Link menggunakan /pharmacy langsung
        </a>
    </p>
    
    <p>
        <a href="{{ url('/pharmacy') }}" class="btn btn-info">
            Link menggunakan url() helper
        </a>
    </p>
</div>
@endsection

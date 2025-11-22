<!-- resources/views/admin/notifications/show.blade.php -->

@extends('Layouts.layout')

@section('content')
<div class="container">
    <h1>Details of Request</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date of Creation</th>
                <th>Type of Request</th>
                <th>Status of Demande</th>
                @if(Auth::user()->role == '1')
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $demande->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $demande->typeDemande->type_demande }}</td>
 
                <td>
                    <span class="badge
                        @if($demande->id_status == 2) bg-success
                        @elseif($demande->id_status == 3) bg-danger
                        @else bg-secondary
                        @endif">
                        {{ $demande->statusDemande->status_demande }}
                    </span>
                </td>
                @if(Auth::user()->role == '1')
                <td>
                    <!-- Add your action here, e.g., verify the profile -->
                    <a href="{{route('profileadmin.show',$demande->id)}}" class="btn btn-primary">Verify Profile</a>
                </td>
                @endif
            </tr>
        </tbody>
    </table>
</div>
@endsection

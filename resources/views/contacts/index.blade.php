@extends('layouts.app')

@section('title')
    List Contacts
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>list contact</h1>
            <p><a href="{{route('contacts.create')}}">Add new contact</a></p>
        </div>
    </div>
    @foreach($contacts as $contact)
        <div class="row">
            <div class="col-4">
                <a href="{{route('contacts.update', ['contact'=> $contact])}}"> {{$contact->name}}</a>
            </div>
            <div class="col-4">{{$contact->email}}</div>
            <div class="col-4">{{$contact->gender}}</div>
        </div>
    @endforeach
    <div class="row">
        <div class="col-12 d-flex justify-content-center pt-4">
            {{$contacts->links()}}
        </div>
    </div>
@endsection

@extends('layouts.master')

@section('content')
<div class="bg-light p-5 mt-5 w-50 mx-auto">
    <h2 class="text-center">Register</h2>
    <form type="submit">
        <div>
            <label>Name</label>
            <input type="text" id="fname" name="fname" placeholder="Your Name" class="w-100 p-2 border"></input>
        </div>
        <div>
            <label>Email</label>
            <input type="text" id="email" name="email" placeholder="Your Email" class="w-100 p-2 border"></input>
        </div>
        <div>
            <label>Password</label>
            <input type="password" id="pwd" name="pwd" placeholder="Your Password" class="w-100 p-2 border"></input>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <button type="button" class="btn btn-success regBtn">Register</button>
        </div>
    </form>
</div>
@stop
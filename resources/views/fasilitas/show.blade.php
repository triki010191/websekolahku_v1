@extends('layouts.app')
@section('title', $facility->name)
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">{{ $facility->name }}</h1></div></section>
<section class="py-5"><div class="container">
    @if($facility->cover)
    <img src="{{ asset('storage/'.$facility->cover) }}" class="img-fluid rounded-3 mb-4" alt="">
    @endif
    <div class="prose max-w-800">{!! $facility->content ?: nl2br(e($facility->description)) !!}</div>
</div></section>
@endsection

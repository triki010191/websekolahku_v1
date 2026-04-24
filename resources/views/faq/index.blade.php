@extends('layouts.app')
@section('title', 'FAQ — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Pertanyaan Umum</h1></div></section>
<section class="py-5"><div class="container" style="max-width:800px">
    <div class="accordion" id="faq">
        @foreach($faqs as $i => $f)
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button {{ $i ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#f{{ $f->id }}">{{ $f->question }}</button>
            </h2>
            <div id="f{{ $f->id }}" class="accordion-collapse collapse {{ $i===0 ? 'show' : '' }}" data-bs-parent="#faq">
                <div class="accordion-body">{!! nl2br(e($f->answer)) !!}</div>
            </div>
        </div>
        @endforeach
    </div>
</div></section>
@endsection

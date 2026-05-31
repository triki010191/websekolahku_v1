@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Periksa isian berikut:</strong>
    <ul class="mb-0 mt-2 ps-3 small">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
</div>
@endif

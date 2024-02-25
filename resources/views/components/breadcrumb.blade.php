@push('styles')
    <style>
    .breadcrumb {
        background: white;
        border: 1px;
        border-radius: 5px;
        padding: 10px 0px;
        margin-top: 10px;
        box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
    }
    li.breadcrumb-item {
        margin-left: 5px;
    }
    </style>
@endpush
<div class="pagetitle">
    <nav>
        {{Breadcrumbs::render()}}
    </nav>
</div>

<style>
.modal-body{
    font-size: medium;
    font-weight: 600;
    color: #6c757d;
    text-transform: capitalize;
}
.modal-title {
    font-size:larger;
    font-weight: 600;
    color: #6c757d;
    text-transform: capitalize;
}
</style>
<div class="modal fade {{ $class ?? '' }}" id="{{ $id }}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}-title" aria-modal="true">
    <div class="modal-dialog {{ $size ?? '' }}" role="document">
        <div class="modal-content shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ Str::slug($title) }}-title">{{ $title }}</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $body }}
            </div>
            {{-- <div class="modal-footer">
                {{ $footer }}
            </div> --}}
        </div>
    </div>
</div>

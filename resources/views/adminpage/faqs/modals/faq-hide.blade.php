@if ($faq->trashed())
    {{-- Visible --}}
    <div class="modal fade" id="visible-faq-{{ $faq->id }}">
        <div class="modal-dialog">
            <div class="modal-content border-primary">
                <div class="modal-header border-primary">
                    <h3 class="h5 modal-title text-primary">
                        <i class="fa-solid fa-eye"></i> Unhide FAQ
                    </h3>
                </div>
                <div class="modal-body">
                    <p><strong>Are you sure you want to unhide this FAQ?</strong></p>
                    ID : {{ $faq->id }}<br>
                    Category : {{ $faq->category->name }}<br>
                    Title : {{ $faq->title }}<br>
                </div>
                <div class="modal-footer border-0">
                    <form action="{{ route('admin.faq.visible', $faq->id) }}" method="post">
                        @csrf
                        @method('PATCH')

                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm">Visible</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    {{-- Hidden --}}
    <div class="modal fade" id="hidden-faq-{{ $faq->id }}">
        <div class="modal-dialog">
            <div class="modal-content border-danger">
                <div class="modal-header border-danger">
                    <h3 class="h5 modal-title text-danger">
                        <i class="fa-solid fa-eye-slash"></i> Hide FAQ
                    </h3>
                </div>
                <div class="modal-body">
                    <p><strong>Are you sure you want to hide?</strong></p>

                    ID : {{ $faq->id }}<br>
                    Category : {{ $faq->category->name }}<br>
                    Title : {{ $faq->title }}<br>
                </div>
                <div class="modal-footer border-0">
                    <form action="{{ route('admin.faq.hidden', $faq->id) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger btn-sm">Hide</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

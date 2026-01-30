<div class="modal fade" id="deleteFaqModal-{{ $faq->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p>
                    <p><strong>Are you sure you want to delete?</strong></p>
                    
                    ID : {{ $faq->id }}<br>
                    Category : {{ $faq->category->name }}<br>
                    Title : {{ $faq->title }}<br>
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>

                <form method="POST" action="{{ route('faq.destroy', $faq->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger ms-2">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

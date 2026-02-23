<div class="modal fade" id="reviewModal{{ $hotel->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('user.reviews.store') }}">
        @csrf
        <input type="hidden" name="target_type" value="hotel">
        <input type="hidden" name="target_id" value="{{ $hotel->id }}">
        <div class="modal-header">
          <h5>レビュー投稿</h5>
        </div>
        <div class="modal-body">

          {{-- 星評価 --}}
          <label for="">評価(0.0〜5.0)</label>
          <input type="number" name="rating" min="0" max="5" step="0.1" class="form-control" required>

          {{-- コメント --}}
          <label class="mt-3" for="">コメント</label>
          <textarea class="form-control" name="comment" id="comment"></textarea>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
          <button class="btn btn-primary" type="submit">投稿</button>
        </div>
      </form>
    </div>
  </div>
</div>
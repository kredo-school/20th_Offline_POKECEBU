{{-- Post Modal --}}
@if ($post->trashed())
    <div class="modal fade" id="unhide-post-{{ $post->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-primary">
                <div class="modal-header border-primary">
                    <h3 class="h5 modal-title text-primary text-start">
                        <i class="fa-regular fa-eye"></i> unhide post
                    </h3>
                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body text-start">

                    <div class="confirmation-message">
                      <p class="modal-subtitle">Post ID: {{ $post->id }}</p>
                        <p>Are you sure you want to make this post</p>
                        <p class="user-name-highlight">Visible Again?</p>

                        {{-- <div class="post-preview-card mt-3">
                            <p class="consequence-text mt-2">{{ Str::limit($post->description, 80) }}</p>
                        </div> --}}
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <form action="{{ route('admin.category-post.activate', $post->id) }}" method="post" class="w-100">
                        @csrf
                        @method('PATCH')

                        <div class="button-group">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-sm px-4">
                                Unhide Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
    {{-- Hide Post Modal --}}
    <div class="modal fade" id="hide-post-{{ $post->id }}">
      <div class="modal-dialog modal-dialog-center">
        <div class="modal-content modal-content-admin deactive-modal">
          <div class="modal-header-admin">

            <div class="modal-header border-danger">
              <h3 class="h5 modal-title text-danger text-start"><i class="fa-solid fa-trash"></i>Hide Post</h3>
              
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body text-start">
            <p class="modal-subtitle">Post ID: #{{ $post->id }}</p>
              <p>Are you sure you want to hide this post?</p>
              <p class="user-name-highlight">Archive Post</p>
          </div>

          <div class="modal-footer border-0">
            <form action="{{ route('admin.category-post.deactivate', $post->id) }}" method="post">
              @csrf
              @method('DELETE')

              <div class="button-group">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger btn-sm px-4">
                  Hide Post
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>



    
@endif

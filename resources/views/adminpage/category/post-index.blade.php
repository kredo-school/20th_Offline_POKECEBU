@extends('layouts.admin')

@section('title', 'Admin Post Settings')

@section('content')

    <style>
        #admin-post-settings-root {
            --primary-blue: #4f46e5;
            --soft-bg: #f8fafc;
            --card-border: #e2e8f0;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --secondary-slate: #64748b;
            
            background-color: var(--soft-bg);
            padding: 40px 20px;
            min-height: 100vh;
            color: var(--text-dark);
            font-family: 'Inter', system-ui, sans-serif;
        }

        #admin-post-settings-root .settings-container {
            max-width: 1400px; /* 項目が多いため少し広めに設定 */
            margin: 0 auto;
        }

        /* Header */
        #admin-post-settings-root .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Sidebar Navigation */
        #admin-post-settings-root .settings-nav {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            padding: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        #admin-post-settings-root .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-radius: 12px;
            text-decoration: none;
            color: var(--text-light);
            font-weight: 600;
            transition: all 0.2s;
            margin-bottom: 4px;
        }

        #admin-post-settings-root .nav-item:hover {
            background: var(--soft-bg);
            color: var(--primary-blue);
        }

        #admin-post-settings-root .nav-item.active {
            background: #eef2ff;
            color: var(--primary-blue);
        }

        /* Main Content Card */
        #admin-post-settings-root .content-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid var(--card-border);
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        #admin-post-settings-root .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        /* Table Style */
        #admin-post-settings-root .table-wrapper {
            overflow-x: auto;
        }

        #admin-post-settings-root .table thead th {
            background: #fcfcfd;
            border-bottom: 1px solid var(--card-border);
            color: var(--text-light);
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            padding: 16px 20px;
            white-space: nowrap;
        }

        #admin-post-settings-root .table tbody td {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            white-space: nowrap;
        }

        /* Thumbnail Image */
        #admin-post-settings-root .post-thumbnail {
            width: 80px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid var(--card-border);
        }

        /* Hide/Unhide Buttons */
        #admin-post-settings-root .btn-status {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            transition: 0.2s;
            border: 1px solid var(--card-border);
            background: #ffffff;
            color: var(--text-light);
        }

        #admin-post-settings-root .btn-status:hover {
            background: var(--soft-bg);
            color: var(--text-dark);
            border-color: var(--text-light);
        }

        /* Badge for Tags */
        #admin-post-settings-root .tag-badge {
            background: #f1f5f9;
            color: var(--text-light);
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
        }
    </style>

    <div id="admin-post-settings-root">
        <div class="settings-container">
            <h1 class="page-title">System Settings</h1>

            <div class="row g-4">
                {{-- Left Side: Navigation --}}
                <div class="col-lg-2">
                    <nav class="settings-nav">
                        <a href="{{ route('admin.category.index') }}" class="nav-item">
                            <i class="fa-solid fa-layer-group me-3"></i> Categories
                        </a>
                        <a href="{{ route('admin.category.type-index') }}" class="nav-item">
                            <i class="fa-solid fa-tags me-3"></i> Types
                        </a>
                        <a href="{{ route('admin.category.post-index') }}" class="nav-item active">
                            <i class="fa-solid fa-signs-post me-3"></i> Post Settings
                        </a>
                    </nav>
                </div>

                {{-- Right Side: Content --}}
                <div class="col-lg-10">
                    <div class="content-card">
                        <div class="card-header-flex">
                            <h2 class="h5 fw-extrabold mb-0">Posts Management</h2>
                        </div>

                        <div class="table-wrapper">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Image</th>
                                        <th>Title / Owner</th>
                                        <th>Tag</th>
                                        <th>Created</th>
                                        <th>Last Updated</th>
                                        <th class="text-end">Visibility</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($all_posts as $post)
                                        <tr>
                                            <td class="text-center text-muted fw-bold">#{{ $post->id }}</td>
                                            <td>
                                                @if ($post->images->isNotEmpty())
                                                    <img src="{{ $post->images->first()->image }}" alt="Post" class="post-thumbnail">
                                                @else
                                                    <img src="{{ asset('images/Icon.png') }}" alt="Default" class="post-thumbnail">
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ Str::limit($post->title, 40) }}</div>
                                                <div class="small text-muted">by {{ $post->user->name ?? 'Unknown' }}</div>
                                            </td>
                                            <td>
                                                <span class="tag-badge">{{ $post->tag->name ?? 'No Tag' }}</span>
                                            </td>
                                            <td>
                                                <div class="small text-muted">{{ optional($post->created_at)->format('Y-m-d') }}</div>
                                            </td>
                                            <td>
                                                <div class="small fw-medium">{{ optional($post->updated_at)->format('Y-m-d') }}</div>
                                                <div class="small text-muted">{{ optional($post->updated_at)->format('H:i') }}</div>
                                            </td>
                                            <td class="text-end">
                                                @if ($post->trashed())
                                                    <button class="btn-status" data-bs-toggle="modal" data-bs-target="#unhide-post-{{ $post->id }}">
                                                        <i class="fa-solid fa-eye me-1"></i> Unhide Post
                                                    </button>
                                                @else
                                                    <button class="btn-status" data-bs-toggle="modal" data-bs-target="#hide-post-{{ $post->id }}">
                                                        <i class="fa-solid fa-eye-slash me-1"></i> Hide Post
                                                    </button>
                                                @endif
                                                @include('adminpage.category.modals.post-status')
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                No posts found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
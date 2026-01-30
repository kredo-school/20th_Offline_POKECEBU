@extends('layouts.admin')

@section('title', 'FAQ List')

@section('content')
    <div class="conteiner">
        <div class="m-5 mt-0 mb-2">
            <div class="mb-2"><a href="{{ route('faq.index') }}">◀︎ FAQ Page</a></div>
            <h3>FAQ details</h3>
            <div class="text-end mb-1">
                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFaqModal-"><i
                        class="fa-solid fa-plus"></i> Add</a>
            </div>


            <table class="table table-hover align-middle bg-white text-secondary">
                <thead class="small table-secondary text-secondary">
                    <th>ID</th>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Order No</th>
                    <th></th>
                    <th><!-- 表示/非表示 --></th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($all_faqs as $faq)
                        <tr>
                            <td>{{ $faq->id }}</td>
                            <td>{{ $faq->category->name }}</td>
                            <td>{{ $faq->title }}</td>
                            <td>{{ $faq->question }}</td>
                            <td>{{ $faq->answer }}</td>
                            <td>{{ $faq->soft_order }}</td>
                            <td>
                                @if ($faq->trashed())
                                    <i class="fa-solid fa-circle-minus text-secondary"></i>&nbsp; Hidden
                                @else
                                    <i class="fa-solid fa-circle text-primary"></i>&nbsp; Visible
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>

                                    <div class="dropdown-menu">
                                        @if ($faq->trashed())
                                            <button class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#visible-faq-{{ $faq->id }}">
                                                <i class="fa-solid fa-eye"></i> Unhide FAQ {{ $faq->id }}
                                            </button>
                                        @else
                                            <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                                data-bs-target="#hidden-faq-{{ $faq->id }}">
                                                <i class="fa-solid fa-eye-slash"></i> Hide FAQ {{ $faq->id }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                @include('adminpage.faqs.modals.faq-hide')
                            </td>
                            <td>
                                <div class="text-end">
                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                        data-bs-target="#updateFaqModal-{{ $faq->id }}"><i class="fa-solid fa-pen"></i></button>
                                    <button class="btn btn-sm btn-outline-danger ms-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteFaqModal-{{ $faq->id }}"><i class="fa-solid fa-trash"></i></button>
                                </div>
                                @include('adminpage.faqs.modals.faq-update')
                                @include('adminpage.faqs.modals.faq-delete')
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('adminpage.faqs.modals.faq-create')
    </div>
@endsection
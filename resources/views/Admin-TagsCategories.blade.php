@extends('layouts.adminlayout')

@section('title', 'Manage Tags and Categories')

@section('content')

<main class="main-content bgc-grey-100">
    <div id="mainContent">
        <div class="container-fluid">
            <h4 class="c-grey-900 mT-10 mB-30">Manajemen Tag dan Kategori</h4>
            <div class="row">
                <!-- Tags Table -->
                <div class="col-md-6">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Daftar Tags</h4>
                        <form action="{{ route('admin.tags.store') }}" method="POST" class="mb-3">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" placeholder="Tag Name" required>
                                <input type="text" name="slug" class="form-control" placeholder="Tag Slug" required>
                                <button type="submit" class="btn btn-success">Add</button>
                            </div>
                        </form>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Tag</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tags as $index => $tag)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $tag->name }}</td>
                                    <td>{{ $tag->slug }}</td>
                                    <td>
                                        <div class="gap-10 peers">
                                            <div class="peer">
                                                <button class="btn cur-p btn-primary btn-color btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $tag->id }}" data-name="{{ $tag->name }}" data-slug="{{ $tag->slug }}" data-type="tag">Edit</button>
                                            </div>
                                            <div class="peer">
                                                <button class="btn cur-p btn-danger btn-color btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $tag->id }}" data-type="tag">Hapus</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Categories Table -->
                <div class="col-md-6">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Daftar Kategori</h4>
                        <form action="{{ route('admin.categories.store') }}" method="POST" class="mb-3">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" placeholder="Category Name" required>
                                <input type="text" name="slug" class="form-control" placeholder="Category Slug" required>
                                <button type="submit" class="btn btn-success">Add</button>
                            </div>
                        </form>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Kategori</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $index => $category)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        <div class="gap-10 peers">
                                            <div class="peer">
                                                <button class="btn cur-p btn-primary btn-color btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-slug="{{ $category->slug }}" data-type="category">Edit</button>
                                            </div>
                                            <div class="peer">
                                                <button class="btn cur-p btn-danger btn-color btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $category->id }}" data-type="category">Hapus</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <!-- Center the modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="itemName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="itemName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="itemSlug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="itemSlug" name="slug" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Are you sure you want to delete this item?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const type = button.getAttribute('data-type'); // Correctly handle the type attribute
        const name = button.getAttribute('data-name');
        const slug = button.getAttribute('data-slug');

        const modalTitle = editModal.querySelector('.modal-title');
        const itemNameInput = editModal.querySelector('#itemName');
        const itemSlugInput = editModal.querySelector('#itemSlug');
        const editForm = editModal.querySelector('#editForm');

        modalTitle.textContent = `Edit ${name}`;
        itemNameInput.value = name;
        itemSlugInput.value = slug;

        // Use the correct route based on the type
        if (type === 'tag') {
            editForm.action = `/admin/tags/${id}`;
        } else if (type === 'category') {
            editForm.action = `/admin/categories/${id}`;
        }
    });

    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const type = button.getAttribute('data-type');

        const deleteForm = deleteModal.querySelector('#deleteForm');
        if (type === 'tag') {
            deleteForm.action = `/admin/tags/${id}`;
        } else if (type === 'category') {
            deleteForm.action = `/admin/categories/${id}`;
        }
    });

    // Automatically generate slug for tags
    const tagNameInput = document.querySelector('input[name="name"][placeholder="Tag Name"]');
    const tagSlugInput = document.querySelector('input[name="slug"][placeholder="Tag Slug"]');
    tagNameInput.addEventListener('input', function () {
        tagSlugInput.value = tagNameInput.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    });

    // Automatically generate slug for categories
    const categoryNameInput = document.querySelector('input[name="name"][placeholder="Category Name"]');
    const categorySlugInput = document.querySelector('input[name="slug"][placeholder="Category Slug"]');
    categoryNameInput.addEventListener('input', function () {
        categorySlugInput.value = categoryNameInput.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    });

    // Automatically generate slug in the edit modal
    const itemNameInput = editModal.querySelector('#itemName');
    const itemSlugInput = editModal.querySelector('#itemSlug');
    itemNameInput.addEventListener('input', function () {
        itemSlugInput.value = itemNameInput.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    });
</script>

@endsection
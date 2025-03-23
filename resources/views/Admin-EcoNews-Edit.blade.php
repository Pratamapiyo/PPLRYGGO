@extends('layouts.adminlayout')

@section('title', 'Edit News')

@section('content')

      <!-- ### $App Screen Content ### -->
      <main class="main-content bgc-grey-100">
        <div id="mainContent">
          <div class="container-fluid p-0">
            <h1 class="h3 mb-3"><strong>Edit News</strong></h1>
            <div class="row d-flex justify-content-center align-items-center">
              <div>
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <!-- Image Section -->
                      <div class="col-md-6">
                        <form action="{{ route('admin.econews.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          @method('PUT')
                          <div class="mb-3">
                            <label for="image" class="form-label"><strong>Upload Image</strong></label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                          </div>
                          <div class="image-box mb-3" style="text-align: center;">
                            <img id="imagePreview" src="{{ $news->image ? asset('storage/' . $news->image) : asset('img/default-image.jpg') }}" 
                                 alt="{{ $news->title }}" class="img-fluid rounded" 
                                 style="width: 100%; height: 400px; object-fit: cover;">
                          </div>
                      </div>

                      <!-- Form Section -->
                      <div class="col-md-6">
                          <div class="mb-3">
                            <label for="title" class="form-label"><strong>Title</strong></label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter title" value="{{ old('title', $news->title) }}">
                          </div>
                          <div class="mb-3">
                            <label for="content" class="form-label"><strong>Content</strong></label>
                            <textarea name="content" id="content" class="form-control" rows="10" placeholder="Enter content">{{ old('content', $news->body) }}</textarea>
                          </div>
                          <div class="mb-3">
                            <label for="categories" class="form-label"><strong>Categories</strong></label>
                            <div class="custom-dropdown" id="categoriesDropdown">
                                <div class="dropdown-selected">Select Categories</div>
                                <div class="dropdown-options">
                                    @foreach ($categories as $category)
                                        <div class="dropdown-option" data-value="{{ $category->id }}">
                                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                                {{ in_array($category->id, $news->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                                            {{ $category->name }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                          </div>
                          <div class="mb-3">
                            <label for="tags" class="form-label"><strong>Tags</strong></label>
                            <div class="custom-dropdown" id="tagsDropdown">
                                <div class="dropdown-selected">Select Tags</div>
                                <div class="dropdown-options">
                                    @foreach ($tags as $tag)
                                        <div class="dropdown-option" data-value="{{ $tag->id }}">
                                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                                {{ in_array($tag->id, $news->tags->pluck('id')->toArray()) ? 'checked' : '' }}>
                                            {{ $tag->name }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                          </div>
                          <div class="mb-3">
                            <label for="slug" class="form-label"><strong>Slug</strong></label>
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="Enter slug" value="{{ old('slug', $news->slug) }}">
                          </div>
                          <div class="text-end">
                            <button type="submit" class="btn btn-success">Save Changes</button>
                            <a href="{{ route('admin.econews.manage') }}" class="btn btn-secondary">Cancel</a>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>

      <style>
        .custom-dropdown {
          position: relative;
          width: 100%;
        }

        .dropdown-selected {
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 5px;
          cursor: pointer;
          background-color: #fff;
        }

        .dropdown-options {
          display: none;
          position: absolute;
          top: 100%;
          left: 0;
          width: 100%;
          border: 1px solid #ccc;
          border-radius: 5px;
          background-color: #fff;
          z-index: 1000;
          max-height: 200px;
          overflow-y: auto;
        }

        .dropdown-option {
          padding: 10px;
          cursor: pointer;
        }

        .dropdown-option:hover {
          background-color: #f0f0f0;
        }

        .dropdown-option input {
          margin-right: 10px;
        }

        .dropdown-options.show {
          display: block;
        }
      </style>

      <script>
        // Preview uploaded image dynamically
        function previewImage(event) {
          const reader = new FileReader();
          reader.onload = function () {
            const output = document.getElementById('imagePreview');
            output.src = reader.result;
          };
          reader.readAsDataURL(event.target.files[0]);
        }

        document.querySelectorAll('.custom-dropdown').forEach(function (dropdown) {
          const selected = dropdown.querySelector('.dropdown-selected');
          const options = dropdown.querySelector('.dropdown-options');
          const checkboxes = options.querySelectorAll('input[type="checkbox"]');

          // Update the selected field with selected options
          function updateSelectedText() {
            const selectedValues = Array.from(checkboxes)
              .filter(checkbox => checkbox.checked)
              .map(checkbox => checkbox.parentElement.textContent.trim());
            selected.textContent = selectedValues.length > 0 ? selectedValues.join(', ') : 'Select Categories';
          }

          // Initialize the selected text
          updateSelectedText();

          selected.addEventListener('click', function () {
            options.classList.toggle('show');
          });

          checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', updateSelectedText);
          });

          document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target)) {
              options.classList.remove('show');
            }
          });
        });
      </script>
@endsection
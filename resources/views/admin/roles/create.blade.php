@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 sidebar">
            @include('admin.partials.sidebar')
        </div>

        <div class="col-md-9 col-lg-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Nieuwe Rol Aanmaken</h1>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Terug
                </a>
            </div>

            <div class="card shadow">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.roles.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Rol Naam <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Beschrijving</label>
                                    <input type="text" 
                                           class="form-control @error('description') is-invalid @enderror" 
                                           id="description" 
                                           name="description" 
                                           value="{{ old('description') }}">
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">
                            <i class="fas fa-key"></i> Rechten Toewijzen
                            <small class="text-muted">(WordPress-stijl)</small>
                        </h5>

                        <div class="permissions-grid">
                            @foreach($permissions as $category => $categoryPermissions)
                            <div class="permission-category card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-{{ 
                                            $category == 'gedetineerden' ? 'user-lock' : 
                                            ($category == 'cellen' ? 'door-closed' : 
                                            ($category == 'rapportage' ? 'chart-bar' : 
                                            ($category == 'gebruikers' ? 'users' : 
                                            ($category == 'rollen' ? 'shield-alt' : 
                                            ($category == 'systeem' ? 'cog' : 
                                            ($category == 'dashboard' ? 'tachometer-alt' : 'key')))))) 
                                        }}"></i>
                                        {{ ucfirst($category) }}
                                        <div class="float-right">
                                            <label class="switch">
                                                <input type="checkbox" class="category-toggle" data-category="{{ $category }}">
                                                <span class="slider"></span>
                                            </label>
                                            <small class="text-muted ml-2">Alles selecteren</small>
                                        </div>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($categoryPermissions as $permission)
                                        <div class="col-md-6 col-lg-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input permission-checkbox" 
                                                       type="checkbox" 
                                                       name="permissions[]" 
                                                       value="{{ $permission->id }}" 
                                                       id="permission_{{ $permission->id }}"
                                                       data-category="{{ $category }}"
                                                       {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                    {{ $permission->description }}
                                                    <small class="text-muted d-block">{{ $permission->name }}</small>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <hr class="my-4">

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Rol Aanmaken
                            </button>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuleren
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.sidebar {
    min-height: 100vh;
    background-color: #f8f9fc;
    border-right: 1px solid #e3e6f0;
}

.main-content {
    padding: 20px;
}

.permission-category .card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #4e73df;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

.form-check-input:checked {
    background-color: #4e73df;
    border-color: #4e73df;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle alle checkboxes in een categorie
    document.querySelectorAll('.category-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const category = this.dataset.category;
            const checkboxes = document.querySelectorAll(`input[data-category="${category}"].permission-checkbox`);
            
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = toggle.checked;
            });
        });
    });
    
    // Update category toggle wanneer individuele checkboxes worden gewijzigd
    document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const category = this.dataset.category;
            const categoryCheckboxes = document.querySelectorAll(`input[data-category="${category}"].permission-checkbox`);
            const categoryToggle = document.querySelector(`input[data-category="${category}"].category-toggle`);
            
            const allChecked = Array.from(categoryCheckboxes).every(cb => cb.checked);
            const noneChecked = Array.from(categoryCheckboxes).every(cb => !cb.checked);
            
            if (allChecked) {
                categoryToggle.checked = true;
                categoryToggle.indeterminate = false;
            } else if (noneChecked) {
                categoryToggle.checked = false;
                categoryToggle.indeterminate = false;
            } else {
                categoryToggle.checked = false;
                categoryToggle.indeterminate = true;
            }
        });
    });
});
</script>
@endsection
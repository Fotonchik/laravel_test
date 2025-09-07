@extends('layout.app')

@section('title', 'Главная страница')

@section('content')
<div class="main-container">
    <div class="hero-section">
        <h1 class="display-4 fw-bold mb-3">Добро пожаловать в наш магазин</h1>
        <p class="lead mb-4">Откройте для себя мир качественных товаров по лучшим ценам</p>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-4">
            <div class="category-sidebar mb-4">
                <h5 class="mb-4">
                    <i class="fas fa-list me-2"></i>Категории товаров
                </h5>
                <div class="category-list">
                    @foreach($categories as $category)
                        <div class="category-item {{ $selectedCategoryId == $category->id ? 'active' : '' }}">
                            <a href="{{ route('home', ['category_id' => $category->id]) }}" 
                               class="d-flex align-items-center text-decoration-none">
                                <i class="fas fa-folder me-3"></i>
                                <span class="flex-grow-1">{{ $category->name }}</span>
                                <span class="badge bg-light text-dark">
                                    {{ $category->total_products_count }}
                                </span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Подкатегории выбранной категории -->
            @if($subcategories->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-sitemap me-2"></i>
                            Подкатегории {{ $selectedCategory->name }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($subcategories as $subcategory)
                                <a href="{{ route('category.show', $subcategory->id) }}" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span>{{ $subcategory->name }}</span>
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $subcategory->total_products_count }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if($selectedCategoryId)
                <div class="d-grid">
                    <a href="{{ route('home') }}" 
                       class="btn btn-outline-primary">
                        <i class="fas fa-times me-2"></i>Показать все товары
                    </a>
                </div>
            @endif
        </div>

        <!-- Основной контент -->
        <div class="col-lg-9 col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">
                        @if($selectedCategory)
                            {{ $selectedCategory->name }}
                            <small class="text-muted">({{ $products->total() }} товаров)</small>
                        @else
                            Все товары
                        @endif
                    </h2>
                    @if($selectedCategory)
                        <p class="text-muted mb-0">Категория: {{ $selectedCategory->name }}</p>
                    @endif
                </div>
                
                <!-- Форма сортировки -->
                <form method="GET" action="{{ route('home') }}" class="d-flex gap-2">
                    @if($selectedCategoryId)
                        <input type="hidden" name="category_id" value="{{ $selectedCategoryId }}">
                    @endif
                    
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="name_asc" {{ $sort == 'name_asc' ? 'selected' : '' }}>По названию (А-Я)</option>
                        <option value="name_desc" {{ $sort == 'name_desc' ? 'selected' : '' }}>По названию (Я-А)</option>
                        <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>По цене (↑)</option>
                        <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>По цене (↓)</option>
                    </select>
                    
                    <select name="per_page" class="form-select" onchange="this.form.submit()">
                        <option value="6" {{ $perPage == 6 ? 'selected' : '' }}>6 на стр.</option>
                        <option value="12" {{ $perPage == 12 ? 'selected' : '' }}>12 на стр.</option>
                        <option value="18" {{ $perPage == 18 ? 'selected' : '' }}>18 на стр.</option>
                    </select>
                </form>
            </div>

            <!-- Сетка товаров -->
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <!-- Пагинация -->
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $products->previousPageUrl() }}{{ $products->onFirstPage() ? '' : '&' . http_build_query(request()->except('page')) }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        
                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                            <li class="page-item {{ $i == $products->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $products->url($i) }}&{{ http_build_query(request()->except('page')) }}">
                                    {{ $i }}
                                </a>
                            </li>
                        @endfor

                        <li class="page-item {{ !$products->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $products->nextPageUrl() }}{{ !$products->hasMorePages() ? '' : '&' . http_build_query(request()->except('page')) }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="text-center mt-2">
                <p class="text-muted small">
                    Показано с {{ $products->firstItem() }} по {{ $products->lastItem() }} из {{ $products->total() }} результатов
                </p>
            </div>
            @else
                <!-- Сообщение, если товаров нет -->
                <div class="text-center py-5">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Товары не найдены</h4>
                    <p class="text-muted">Попробуйте изменить параметры фильтрации</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-undo me-2"></i>Показать все товары
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
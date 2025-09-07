@extends('layout.app')

@section('title', $category->name)

@section('content')
<div class="main-container">
    <!-- Ссылки -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <i class="fas fa-home me-1"></i>Главная
                </a>
            </li>
            @php
                $current = $category;
                $chain = [];
                while ($current) {
                    $chain[] = $current;
                    $current = $current->parent;
                }
                $chain = array_reverse($chain);
            @endphp
            @foreach($chain as $breadcrumb)
                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                    @if(!$loop->last)
                        <a href="{{ route('category.show', $breadcrumb->id) }}" class="text-decoration-none">
                            {{ $breadcrumb->name }}
                        </a>
                    @else
                        {{ $breadcrumb->name }}
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-3 col-md-4">
            <div class="category-sidebar mb-4">
                <h5 class="mb-4">
                    <i class="fas fa-sitemap me-2"></i>Подкатегории
                </h5>
                <div class="category-list">
                    @foreach($subcategories as $subcategory)
                        <div class="category-item">
                            <a href="{{ route('category.show', $subcategory->id) }}" 
                               class="d-flex align-items-center text-decoration-none">
                                <i class="fas fa-folder me-3"></i>
                                <span class="flex-grow-1">{{ $subcategory->name }}</span>
                                <span class="badge bg-light text-dark">
                                    {{ $subcategory->total_products_count }}
                                </span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="d-grid">
                <a href="{{ $category->parent ? route('category.show', $category->parent->id) : route('home') }}" 
                   class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>
                    {{ $category->parent ? 'Назад' : 'На главную' }}
                </a>
            </div>
        </div>

        <!-- Основной контент -->
        <div class="col-lg-9 col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 mb-2">{{ $category->name }}</h1>
                    <p class="text-muted mb-0">Найдено товаров: {{ $products->total() }}</p>
                </div>
                <form method="GET" action="{{ route('category.show', $category->id) }}" class="d-flex gap-2">
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
                <div class="text-center py-5">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Товары не найдены</h4>
                    <p class="text-muted">В этой категории пока нет товаров</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@extends('layout.app')

@section('title', $product->name)

@section('content')
<div class="main-container">
    <!-- Хлебные крошки -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <i class="fas fa-home me-1"></i>Главная
                </a>
            </li>
            
            @if($product->group)
                <!-- Получаем полную цепочку категорий -->
                @php
                    $categoryChain = [];
                    $currentCategory = $product->group;
                    
                    // Собираем цепочку категорий от текущей до корневой
                    while ($currentCategory) {
                        $categoryChain[] = $currentCategory;
                        $currentCategory = $currentCategory->parent;
                    }
                    $categoryChain = array_reverse($categoryChain);
                @endphp
                
                @foreach($categoryChain as $category)
                    <li class="breadcrumb-item">
                        <a href="{{ route('category.show', $category->id) }}" class="text-decoration-none">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            @endif
            
            <li class="breadcrumb-item active" aria-current="page">
                {{ $product->name }}
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h1 class="h2 fw-bold mb-3">{{ $product->name }}</h1>
                
                @if($product->group)
                    <div class="mb-3">
                        <span class="badge bg-primary fs-6">
                            <i class="fas fa-tag me-2"></i>
                            Категория: {{ $product->group->name }}
                        </span>
                    </div>
                @endif
                
                <!-- Цена -->
                <div class="d-flex align-items-center mb-4">
                    <span class="price fs-1 fw-bold">
                        {{ number_format($product->prices->first()->price, 0, '.', ' ') }} ₽
                    </span>
                </div>
                
                
                <!-- Кнопки действий  (Заглушка)-->
                <div class="d-grid gap-2 d-md-flex mb-4">
                    <button class="btn btn-primary btn-lg flex-fill">
                        <i class="fas fa-shopping-cart me-2"></i>Добавить в корзину
                    </button>
                    <button class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-heart me-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
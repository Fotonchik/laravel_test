<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
    <div class="card h-100 border-0 shadow-hover">
        
        
        <div class="card-body d-flex flex-column">
            @if($product->group)
                <div class="mb-2 text-success">
                    <span>
                        <i class="fas fa-tag me-1 "></i>{{ $product->group->name }}
                    </span>
                </div>
            @endif
            
            <h6 class="card-title mb-2">
                <a href="{{ route('product.show', $product->id) }}" 
                   class="text-decoration-none text-dark stretched-link">
                    {{ \Illuminate\Support\Str::limit($product->name, 50) }}
                </a>
            </h6>
            
            <div class="mt-auto">
                <span class="price fs-5 fw-bold">
                    {{ number_format($product->getCurrentPrice(), 0, '.', ' ') }} ₽
                </span>
            </div>
        </div>
        
        <!-- Футер карточки -->
        <div class="card-footer bg-transparent border-0 pt-0">
            <div class="d-grid">
                <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">
                    <i class="fas fa-eye me-2"></i>Подробнее
                </a>
            </div>
        </div>
    </div>
</div>
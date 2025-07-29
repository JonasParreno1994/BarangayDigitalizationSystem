@extends("layouts.adminLayout.index")
@section("content")
<div class="container-fluid px-4 py-5">
    <div class="cards-container">
        @if($dashboardItems->count() > 0)
            @php $item = $dashboardItems->first(); @endphp
            @for($i = 1; $i <= 5; $i++)
                <div class="card-wrapper">
                    <div class="card h-100 border-0 text-center etch-effect">
                        <div class="card-body p-4">
                            <div class="card-content-wrapper">
                                <div class="card-image-section">
                                    @if($item->{"image{$i}_path"})
                                        <img src="{{ Storage::url($item->{"image{$i}_path"}) }}" 
                                             class="img-fluid mx-auto d-block"
                                             style="height: 80px; width: auto;"
                                             onerror="this.onerror=null;this.src='{{ asset('images/default-service.png') }}'">
                                    @endif
                                </div>
                                <h5 class="card-title fw-bold">{{ $item->{"title{$i}"} ?? 'Service Title' }}</h5>
                                <p class="card-text text-muted small">
                                    {{ $item->{"description{$i}"} ?? 'Sample text. Click to select the text box. Click again or double click to start editing the text.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        @endif
    </div>
</div>

<style>
    .cards-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0;
        justify-content: center;
        align-items: flex-start; 
    }
    
    .card-wrapper {
        flex: 1;
        min-width: 200px;
        max-width: 300px;
    }
    
    .card {
        transition: all 0.3s ease;
        background-color: #f8f9fa;
        position: relative;
        overflow: hidden;
        border-radius: 0 !important; 
        margin: 0;
        min-height: 100%;
        display: flex;
        flex-direction: column;
    }
    
   
    .card-wrapper:not(:last-child) .card {
        border-right: 1px solid #dee2e6;
    }
    
    .card-wrapper:first-child .card {
        border-top-left-radius: 0.375rem !important;
        border-bottom-left-radius: 0.375rem !important;
    }
    
    .card-wrapper:last-child .card {
        border-top-right-radius: 0.375rem !important;
        border-bottom-right-radius: 0.375rem !important;
    }
    
    
    .etch-effect::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: 0.5s;
        z-index: 1;
    }
    
    .etch-effect:hover::before {
        left: 100%;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        z-index: 10;
    }
    
  
    .card-body {
        position: relative;
        z-index: 2;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .card-content-wrapper {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .card-image-section {
        flex-shrink: 0;
        margin-bottom: 1rem;
    }
    
    .card-title {
        color: #4e73df;
        flex-shrink: 0;
        margin-bottom: 1rem;
    }
    
    .card-text {
        flex: 1;
        line-height: 1.4;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    h1.display-5 {
        color: #2c3e50;
        font-weight: 700;
    }
    
    .lead {
        line-height: 1.8;
    }
    
    .card-title {
        color: #4e73df;
    }
    

    @media (max-width: 1200px) {
        .card-wrapper {
            max-width: 250px;
        }
    }
    
    @media (max-width: 992px) {
        .cards-container {
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .card-wrapper {
            flex: 0 0 calc(50% - 7.5px);
            max-width: none;
        }
        
        .card {
            border-radius: 0.375rem !important;
            border-right: none !important;
        }
    }
    
    @media (max-width: 768px) {
        .card-wrapper {
            flex: 0 0 100%;
        }
        
        .cards-container {
            gap: 15px;
        }
    }
</style>
@endsection
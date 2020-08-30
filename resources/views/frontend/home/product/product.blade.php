@if(count($slideProductCategories) > 0)
<div class="product-area pb-190">
    <div class="container">
        <div class="section-title text-center mb-50">
            <h2>CHOOSE YOUR BIKE</h2>
            <p><span>OSWAN</span> the most latgest bike store in the wold can serve you latest qulity of motorcycle also
                you can sell here your motorcycle</p>
        </div>
        <div class="product-tab-list text-center mb-80 nav product-menu-mrg" role="tablist">

            @foreach($slideProductCategories as $key => $slideProductCategory)
            <a @if($key==0) class='active' @endif href="#slide{{ $slideProductCategory->id }}" data-toggle="tab">
                <h4>{{ $slideProductCategory->name }} </h4>
            </a>
            @endforeach

        </div>
        <div class="tab-content jump">

            @foreach($slideProductCategories as $key => $slideProductCategory)
            <div class="tab-pane @if($key==0) active @endif" id="slide{{ $slideProductCategory->id }}">
                <div class="row">
                    @if(count($slideProductCategory->products) > 0)

                    @foreach($slideProductCategory->products()->latest()->limit(6)->get() as $product)

                    <div class="col-md-4 mb-4">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="product-details.html">
                                    <img src="{{ asset($product->thumbnail)}}" alt="">
                                </a>
                                <div class="product-item-dec">
                                    <ul>
                                        <li>{{ $product->model }}</li>
                                        <li>{{ $product->fuel_type }}</li>
                                        <li>{{ $product->cc }} CC</li>
                                    </ul>
                                </div>
                                <div class="product-action">
                                    <a class="action-plus-2" title="Add To Cart" href="#">
                                        <i class=" ti-shopping-cart"></i>
                                    </a>
                                    <a class="action-cart-2" title="Wishlist" href="#">
                                        <i class=" ti-heart"></i>
                                    </a>
                                    <a class="action-reload" title="Quick View" data-toggle="modal"
                                        data-target="#exampleModal" href="#">
                                        <i class=" ti-zoom-in"></i>
                                    </a>
                                </div>
                                <div class="product-content-wrapper">
                                    <div class="product-title-spreed">
                                        <h4><a href="product-details.html">{{ $product->title }}</a></h4>
                                        <span>{{ $product->rpm }} RPM</span>
                                    </div>
                                    <div class="product-price">
                                        <span>${{ $product->final_price }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endif
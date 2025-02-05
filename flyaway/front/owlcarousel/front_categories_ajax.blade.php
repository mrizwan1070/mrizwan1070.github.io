 @if($home_categories)
                    @foreach($home_categories as $home_category)
                    <div class="category-tabs mb-5">
                        <div class="row justify-content-between flex-xl-row flex-column align-items-center">
                            <h2>{{$home_category->title}}</h2>
                            <ul class="nav prd-tab-home">
                                @if($home_category->child_categories)
                                @foreach($home_category->child_categories as $ind => $child_category)
                                <li class="nav-item"><a href="#{{$child_category->url_key}}" data-toggle="tab" class="nav-link <?php if ($ind == 0) {
                                                                                                                                    echo 'active';
                                                                                                                                } ?>">{{$child_category->title}}</a></li>
                                @endforeach
                                @endif
                                {{-- <li class="nav-item"><a href="#protectors" data-toggle="tab" class="nav-link">Protectores</a></li>
                                <li class="nav-item"><a href="#chargers" data-toggle="tab" class="nav-link">Chargers</a></li>
                                <li class="nav-item"><a href="memory" data-toggle="tab" class="nav-link">Memory & Storage</a></li>
                                <li class="nav-item"><a href="smartwatch" data-toggle="tab" class="nav-link">SmartWatches</a></li> --}}
                            </ul>
                        </div>
                        <div class="tab-content">
                            @if($home_category->child_categories)
                            @foreach($home_category->child_categories as $index => $child_category)
                            <div class="tab-pane fade <?php if ($index == 0) {
                                                            echo 'active show';
                                                        } ?>" id="{{$child_category->url_key}}">
                                <div class="row">
                                    @if($child_category->products)
                                    @foreach( $child_category->products as $product)
                                    <div class="col-xl-2 col-md-3 col-sm-6 mb-3 px-1">
                                        <div class="prd-card text-center my-shadow">
                                            <div class="prd-img-action-btn position-relative">
                                                <div class="prd-img pt-2">
                                                    <a href="">
                                                        <img src="<?php echo image($product, "product_image"); ?>" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="action-btns shadow bg-white w-75  position-absolute">
                                                    <span><button type="button" class="btn btn-link">
                                                            <i class="fa-regular fa-heart"></i>
                                                        </button></span>
                                                    <span>
                                                        <a href="#" class="btn btn-link">
                                                            <i class="fa-solid fa-scale-balanced"></i>
                                                        </a>
                                                    </span>
                                                    <span>
                                                        <a href="#" class="btn btn-link">
                                                            <i class="fa-solid fa-magnifying-glass"></i> </a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="prd-detail py-2 px-1">
                                                <div class="prd-title">
                                                    <a href="<?php product_detail_url($product);?>">
                                                        <p>
                                                            {{$product->title}}
                                                        </p>
                                                    </a>
                                                </div>
                                                <div class="prd-price">
                                                    <span class="sale-price mr-1 text-dark font-weight-bold">
                                                        {{ $product->currency_sign}} {{ $product->price}}
                                                    </span>
                                                    <span class="price-rrp text-secondary font-weight-bold">
                                                        <del>{{ $product->currency_sign}} {{ $product->rrp}}</del>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif
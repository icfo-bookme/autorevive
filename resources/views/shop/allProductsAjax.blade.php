  {{-- <link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.css')}}">
  <link href="{{asset('styles/shop_styles.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('styles/shop_responsive.css')}}" rel="stylesheet" type="text/css"> --}}


  {{-- <div class="product_grid">
      <div class="product_grid_border"></div>


      @foreach($allProducts as $item)
      
      <div class="product_item is_new">
          <div class="product_border"></div>
          <a href="{{url('singleProductDetails',$item->id)}}" tabindex="0">
              <div class="product_image d-flex flex-column align-items-center justify-content-center"><img
                      src="{{asset($item->thumbnail)}}" alt=""></div>
          </a>
          <div class="product_content">
              <div class="product_price">৳{{$item->sales_price}}</div>
              <div class="product_name">
                  <div class="px-2 text-truncate"><a href="{{url('singleProductDetails',$item->id)}}"
                          tabindex="0">{{$item->name}}<small style="font-size: 55%">(Min Order
                              {{$item->minimum_order_quantity}})</small></a></div>
              </div>
              <button class="btn customized-btn" onclick="addToCart({{$item->id}})">Add to Cart</button>
          </div>
          <div class="product_fav"><i class="fas fa-heart"></i></div>
          <ul class="product_marks">
          </ul>
      </div>

      @endforeach
  </div> --}}


  @foreach($allProducts as $item)
  {{-- @dd($item); --}}
  <div class="col-lg-3 col-md-4 col-12 ">
    <article class="single_product">
        <figure>
            <div class="product_thumb">
                <a class="primary_img" href="{{url('singleProductDetails',$item->id)}}"><img src="{{asset($item->thumbnail)}}" alt=""></a>
                <a class="secondary_img" href="{{url('singleProductDetails',$item->id)}}"><img src="{{asset($item->thumbnail)}}" alt=""></a>
                <div class="label_product">
                    <span class="label_sale">-44%</span>
                </div>
                <div class="quick_button">
                    <a href="{{url('singleProductDetails',$item->id)}}"  title="quick view"><i class="icon-eye"></i></a>
                </div>
            </div>
            <div class="product_content grid_content">
                <div class="product_content_inner">
                    <p class="manufacture_product"><a href="#">{{ $item->category->name }}</a></p>
                    <h4 class="product_name"><a href="{{url('singleProductDetails',$item->id)}}">{{ $item->name }}</a>
                    </h4>
                    <div class="product_rating">
                        <ul>
                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                        </ul>
                    </div>
                    <div class="price_box">
                        <span class="old_price">৳{{ $item->regular_price }}</span>
                        <span class="current_price">৳{{ $item->sales_price }}</span>
                    </div>
                </div>
                <div class="action_links">
                    <ul>
                        <li class="add_to_cart"><a href="#" onclick="addToCart({{ $item->id }})" title="Add to cart">Add to
                                cart</a></li>
                        <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                    class="icon-heart"></i></a></li>
                        <li class="compare"><a href="#" title="Add to Compare"><i
                                    class="icon-rotate-cw"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="product_content list_content">
                <div class="left_caption">
                    <p class="manufacture_product"><a href="#">{{ $item->category->name }}</a></p>
                    <h4 class="product_name"><a {{url('singleProductDetails',$item->id)}}>{{ $item->name }}</a>
                    </h4>
                    <div class="product_rating">
                        <ul>
                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                        </ul>
                    </div>
                    <div class="price_box">
                        <span class="old_price">৳{{ $item->regular_price }}</span>
                        <span class="current_price">৳{{ $item->sales_price }}</span>
                    </div>
                    <div class="product_desc">
                        <p>{{ $item->details }}</p>
                    </div>
                </div>
                <div class="right_caption">
                    <p class="text_available">Availability: <span>In Stock</span></p>
                    <div class="action_links">
                        <ul>
                            <li class="add_to_cart"><a href="#" onclick="addToCart({{ $item->id }})" title="Add to cart">Add
                                    to
                                    cart</a></li>
                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i
                                        class="icon-heart"></i> Add to
                                    Wishlist</a></li>
                            <li class="compare"><a href="#" title="compare"><i
                                        class="icon-rotate-cw"></i>Add to Compare</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </figure>
    </article>
  </div>
  @endforeach

{{-- 
  <script src="{{asset('plugins/Isotope/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.js')}}"></script>
  <script src="{{asset('plugins/parallax-js-master/parallax.min.js')}}"></script>
  <script src="{{asset('js/shop_custom.js')}}"></script> --}}

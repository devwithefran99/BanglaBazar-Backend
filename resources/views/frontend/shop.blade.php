<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | BanglaBazar</title>
<!-- shop link part starts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="navbar-active.css">
  <link rel="stylesheet" href="{{ asset ('frontend/css/common.css')}}">
  <link rel="stylesheet" href="{{ asset ('frontend/css/shop.css')}}">
  <link rel="stylesheet" href="{{ asset ('frontend/css/responsive.css')}}">
<!-- shop link ends -->

</head>
<body>
<!-- preloader  -->

  <div id="preloader">
  <div class="loader">
    <img src=" {{ asset('frontend/image/Logo.png')}}" alt="Logo">  
    <p>Loading...</p>   
  </div>
</div>

<!-- preloader ends -->
    
    <!-- header part starts here -->
 <header>
    <!-- nav bar starts -->
<section id="navigation">
        <!-- ════════════════════════════════════════
     TOP BAR
════════════════════════════════════════ -->
<div class="topbar d-none d-md-block">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <i class="bi bi-geo-alt-fill text-success me-1"></i>
         Store Location: 5th Floor,Kazi Complex,Beparipara,Agrabad Access Road,Chattogram
      </div>
      <div class="d-flex align-items-center gap-2">
        <span class="sep">|</span>
        <a href="signIn.html"><i class="bi bi-person me-1"></i>Sign In /</a>
        <a href="createAccount.html"><i class="bi bi-person me-1"></i>Sign Up</a>
      </div>
    </div>
  </div>
</div>
 
<!-- ════════════════════════════════════════
     MIDDLE BAR
════════════════════════════════════════ -->
<div class="middlebar d-flex align-items-center justify-content-between">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between gap-3">
 
      <!-- Logo -->
      <a href="#" class="logo-slot">
        <img src=" {{ asset('frontend/image/Logo.png')}}" height="35" alt="logo">
       
      </a>
      <div class="d-lg-none ms-auto">   
        <button class="navbar-toggler-custom" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#mobileNav">
            <i class="bi bi-list"></i>
        </button>
    </div>
 
      <!-- Search (lg+ only) -->
      <div class="search-wrap flex-grow-1 mx-3">
        <input type="text" placeholder="Search for products..."/>
        <button><i class="bi bi-search me-1"></i>Search</button>
      </div>
 
      <!-- Icons -->
      <div class="d-none d-lg-flex align-items-center gap-2">
        <a href="wishlist.html" class="icon-btn">
          <i class="bi bi-heart"></i>
          <span class="badge-dot">3</span>
        </a>
        <a href="#" class="icon-btn cart-btn ">
          <i class="bi bi-bag"></i>
          <span class="badge-dot">3</span>
        </a>
      </div>
 
    </div>
  </div>
</div>
 
<!-- ════════════════════════════════════════
     MAIN NAVBAR (desktop)
════════════════════════════════════════ -->
<nav class="main-navbar">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between">
 
      <!-- Desktop nav links -->
      <ul class="nav d-none d-lg-flex">
 
        <li class="nav-item">
          <a class="nav-link " href="index.html" >
            <i class="bi bi-house-door-fill me-1"></i> Home
          </a>
        </li>
 
        <li class="nav-item">
          <a class="nav-link" href="shop.html">
            <i class="bi bi-shop me-1"></i> Shop
          </a>
        </li>
 
         <li class="nav-item dropdown-custom">
  <a class="nav-link" href="#">
    <i class="bi bi-file-earmark-text me-1"></i> Pages
  </a>
  <ul class="submenu">
    <li><a href="wishlist.html">Wishlist</a></li>
     <li><a href="userdashboard.html">Order History</a></li>
    <li><a href="singleProduct.html">CheckOut</a></li>
     <li><a href="signIn.html">Sign In</a></li>
   <li><a href="createAccount.html">Sign Up</a></li>
     <li><a href="faq.html">FAQS</a></li>
      <li><a href="userdashboard.html">My Account</a></li>
  </ul>
</li>

        </li>
 
       
 
        <li class="nav-item">
             <a class="nav-link" href="about.html"><i class="bi bi-info-circle me-1"></i> About Us</a>
        </li>
 
        <li class="nav-item">
          <a class="nav-link" href="contact.html"><i class="bi bi-telephone me-1"></i> Contact Us</a>
        </li>
      </ul>
 
      <!-- Phone (desktop) -->
      <div class="nav-phone d-none d-lg-flex">
        <i class="bi bi-telephone-fill"></i>
        01616-239896
      </div>
 
      <!-- Hamburger (mobile/tablet) -->
      
 
    </div>
  </div>
</nav>
 
<!-- ════════════════════════════════════════
     OFFCANVAS (mobile sidebar)
════════════════════════════════════════ -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNav">
  <div class="offcanvas-header">
    <img src=" {{ asset('frontend/image/Logo.png')}}" alt="">
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
 
    <!-- Mobile search -->
    <div class="p-3 border-bottom">
      <div class="d-flex">
        <input type="text" class="form-control" placeholder="Search products..."/>
        <button class="btn ms-2" style="background:var(--green);color:#fff;">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </div>
 
    <nav class="d-flex flex-column">
 
      <!-- Home -->
      <a class="nav-link" href="index.html">
        <span><i class="bi bi-house-door-fill me-2 text-success"></i>Home</span>
        <i class="bi bi-chevron-down arrow"></i>
      </a>
 
      <!-- Shop -->
       
      <a class="nav-link"  href="shop.html">
        <span><i class="bi bi-shop me-2 text-success"></i>Shop</span>
        <i class="bi bi-chevron-down arrow"></i>
      </a>

 
      <!-- Pages -->
      <div class="mobile-menu-item">
  <a class="nav-link mobile-toggle" href="javascript:void(0)">
    <span>
      <i class="bi bi-file-earmark-text me-2 text-success"></i>Pages
    </span>
    <i class="bi bi-chevron-down arrow"></i>
  </a>

  <ul class="mobile-submenu">
     <li><a href="wishlist.html">Wishlist</a></li>
     <li><a href="userdashboard.html">Order History</a></li>
    <li><a href="singleProduct.html">CheckOut</a></li>
     <li><a href="signIn.html">Sign In</a></li>
   <li><a href="createAccount.html">Sign Up</a></li>
     <li><a href="faq.html">FAQS</a></li>
      <li><a href="userdashboard.html">My Account</a></li>
  </ul>
</div>
      
      <a class="nav-link" href="about.html">
       <span><i class="bi bi-info-circle me-2 text-success"></i>About Us</span>
      </a>
 
      <a class="nav-link" href="contact.html">
        <span><i class="bi bi-telephone me-2 text-success"></i>Contact Us</span>
      </a>
 
    </nav>
 
    <!-- Phone bottom -->
    <div class="offcanvas-phone">
      <i class="bi bi-telephone-fill"></i> 01616-239896
    </div>
 
  </div>
</div>
</section>

    <!-- nav bar ends  -->
 </header>

 <!-- Breadcrumbs Part starts -->
<section id="shopBanner">
    <div class="shopBnr">
        
    </div>
</section>
 <!-- Breadcrumbs part ends -->

 <!-- shop main part -->
  <main>
    <section class="content">
    <div class="container p-0">
    <div class="row g-0">
        
        <!-- FILTER SIDEBAR -->
       <!-- FILTER SIDEBAR -->
<div class="col-lg-3 filter-sidebar" id="filter-sidebar">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="mb-0 fw-bold">All Categories</h5>
        <button onclick="closeSidebar()" class="btn btn-success btn-sm d-lg-none"><i class="bi bi-x-lg"></i></button>
    </div>

    <!-- Categories -->
    <div id="categories-list" class="mb-4"></div>

    <!-- Popular Tag Section -->
<div class="mb-4">
    <h6 class="fw-bold mb-3 text-white">Popular Tag</h6>
    <div class="d-flex flex-wrap gap-2" id="tags-container"></div>
</div>

    <!-- Discount Banner -->
    <div class="bg-white text-dark p-4 rounded-4 mb-4 text-center" 
         style="background: linear-gradient(135deg, #f8fafc, #e0f2e9);">
        <h4 class="fw-bold text-success mb-1">79% Discount</h4>
        <p class="mb-3 small">on your first order</p>
        <a href="#" class="btn btn-success btn-sm px-4">Shop Now <i class="bi bi-arrow-right"></i></a>
    </div>

    <div class="text-center mt-5 text-muted small">82 Results Found</div>
</div>

        <!-- MAIN CONTENT -->
        <div class="col-lg-9">
            <div class="top-bar d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <button onclick="toggleSidebar()" class="filter-btn btn btn-success d-lg-none">
                        <i class="bi bi-list"></i> 
                    </button>
                    <h4 class="mb-0 fw-semibold text-dark">Products</h4>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <input type="text" id="searchInput" class="form-control d-none d-lg-block" placeholder="Search products..." style="width: 240px;" onkeyup="filterProducts()">
                    
                    <select id="sortSelect" class="form-select" style="width: 160px;" onchange="filterProducts()">
                        <option value="latest">Latest</option>
                        <option value="name">Name A-Z</option>
                    </select>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="p-4">
                <div class="row g-4" id="product-grid">
                    
                    <!-- ==================== VEGETABLES CARDS ==================== -->
                    <div class="col-6 col-lg-4 col-xl-3 product-col vegetables">
                        <div class="hotProduct-card">
                            <div class="product-img-wrap">
                                <div class="img-overlay">
                                    <div class="overlay-icons">
                                        <button><i class="bi bi-heart"></i></button>
                                        <button title="Quick View"><i class="bi bi-eye"></i></button>
                                    </div>
                                </div>
                                <img src=" {{ asset('frontend/image/Product Image (2).png')}}" alt="Big Potatoes">
                            </div>
                            <div class="card-body-custom">
                                <div class="product-name">Big Potatoes</div>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star empty"></i>
                                </div>
                                <div class="price-row">
                                    <span class="price-main">$14.99</span>
                                     <a href="#"  class="cart-btn"><i class="bi bi-bag"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- আরও Vegetables কার্ড যোগ করো এখানে (একই structure) -->
                    <!-- উদাহরণ: Chinese Cabbage -->
                    <div class="col-6 col-lg-4 col-xl-3 product-col vegetables">
                        <div class="hotProduct-card">
                            <div class="product-img-wrap">
                                <div class="img-overlay">
                                    <div class="overlay-icons">
                                        <button><i class="bi bi-heart"></i></button>
                                        <button title="Quick View"><i class="bi bi-eye"></i></button>
                                    </div>
                                </div>
                                <img src=" {{ asset('frontend/image/bigApple.png')}}" alt="Chinese Cabbage">
                            </div>
                            <div class="card-body-custom">
                                <div class="product-name">Chinese Cabbage</div>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <div class="price-row">
                                    <span class="price-main">$14.99</span>
                                     <button href="singleProduct.html"  class="cart-btn"><i class="bi bi-bag"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-4 col-xl-3 product-col vegetables">
                        <div class="hotProduct-card">
                            <div class="product-img-wrap">
                                <div class="img-overlay">
                                    <div class="overlay-icons">
                                        <button><i class="bi bi-heart"></i></button>
                                        <button title="Quick View"><i class="bi bi-eye"></i></button>
                                    </div>
                                </div>
                                <img src=" {{ asset('frontend/image/hotProduct1 (1).png')}}" alt="Chinese Cabbage">
                            </div>
                            <div class="card-body-custom">
                                <div class="product-name">Chinese Cabbage</div>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <div class="price-row">
                                    <span class="price-main">$14.99</span>
                                     <button href="singleProduct.html"  class="cart-btn"><i class="bi bi-bag"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <!-- ==================== FRESH FRUIT CARDS ==================== -->
                    <div class="col-6 col-lg-4 col-xl-3 product-col fresh-fruit">
                        <div class="hotProduct-card">
                            <div class="product-img-wrap">
                                <div class="img-overlay">
                                    <div class="overlay-icons">
                                        <button><i class="bi bi-heart"></i></button>
                                        <button title="Quick View"><i class="bi bi-eye"></i></button>
                                    </div>
                                </div>
                                <img src=" {{ asset('frontend/image/hotProduct1 (2).png')}}" alt="Green Apple">
                            </div>
                            <div class="card-body-custom">
                                <div class="product-name">Green Apple</div>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star empty"></i>
                                    <i class="bi bi-star empty"></i>
                                </div>
                                <div class="price-row">
                                    <span class="price-main">$14.99</span>
                                     <button href="singleProduct.html"  class="cart-btn"><i class="bi bi-bag"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-4 col-xl-3 product-col fresh-fruit">
                        <div class="hotProduct-card">
                            <div class="product-img-wrap">
                                <div class="img-overlay">
                                    <div class="overlay-icons">
                                        <button><i class="bi bi-heart"></i></button>
                                        <button title="Quick View"><i class="bi bi-eye"></i></button>
                                    </div>
                                </div>
                                <img src=" {{ asset('frontend/image/hotProduct1 (3).png')}}" alt="Green Apple">
                            </div>
                            <div class="card-body-custom">
                                <div class="product-name">Green Apple</div>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star empty"></i>
                                    <i class="bi bi-star empty"></i>
                                </div>
                                <div class="price-row">
                                    <span class="price-main">$14.99</span>
                                     <button href="singleProduct.html"  class="cart-btn"><i class="bi bi-bag"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-4 col-xl-3 product-col fresh-fruit">
                        <div class="hotProduct-card">
                            <div class="product-img-wrap">
                                <div class="img-overlay">
                                    <div class="overlay-icons">
                                        <button><i class="bi bi-heart"></i></button>
                                        <button title="Quick View"><i class="bi bi-eye"></i></button>
                                    </div>
                                </div>
                                <img src=" {{ asset('frontend/image/hotProduct1 (4).png')}}" alt="Green Apple">
                            </div>
                            <div class="card-body-custom">
                                <div class="product-name">Green Apple</div>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star empty"></i>
                                    <i class="bi bi-star empty"></i>
                                </div>
                                <div class="price-row">
                                    <span class="price-main">$14.99</span>
                                     <button href="singleProduct.html"  class="cart-btn"><i class="bi bi-bag"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-4 col-xl-3 product-col fresh-fruit">
                        <div class="hotProduct-card">
                            <div class="product-img-wrap">
                                <div class="img-overlay">
                                    <div class="overlay-icons">
                                        <button><i class="bi bi-heart"></i></button>
                                        <button title="Quick View"><i class="bi bi-eye"></i></button>
                                    </div>
                                </div>
                                <img src=" {{ asset('frontend/image/Product Image (1).png')}}" alt="Green Apple">
                            </div>
                            <div class="card-body-custom">
                                <div class="product-name">Green Apple</div>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star empty"></i>
                                    <i class="bi bi-star empty"></i>
                                </div>
                                <div class="price-row">
                                    <span class="price-main">$14.99</span>
                                     <button href="singleProduct.html"  class="cart-btn"><i class="bi bi-bag"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-4 col-xl-3 product-col cooking">
                        <div class="hotProduct-card">
                            <div class="product-img-wrap">
                                <div class="img-overlay">
                                    <div class="overlay-icons">
                                        <button><i class="bi bi-heart"></i></button>
                                        <button title="Quick View"><i class="bi bi-eye"></i></button>
                                    </div>
                                </div>
                                <img src=" {{ asset('frontend/image/Product Image (3).png')}}" alt="Green Apple">
                            </div>
                            <div class="card-body-custom">
                                <div class="product-name">Green Apple</div>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star empty"></i>
                                    <i class="bi bi-star empty"></i>
                                </div>
                                <div class="price-row">
                                    <span class="price-main">$14.99</span>
                                     <button href="singleProduct.html"  class="cart-btn"><i class="bi bi-bag"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-4 col-xl-3 product-col cooking">
                        <div class="hotProduct-card">
                            <div class="product-img-wrap">
                                <div class="img-overlay">
                                    <div class="overlay-icons">
                                        <button><i class="bi bi-heart"></i></button>
                                        <button title="Quick View"><i class="bi bi-eye"></i></button>
                                    </div>
                                </div>
                                <img src=" {{ asset('frontend/image/Product Image (4).png')}}" alt="Green Apple">
                            </div>
                            <div class="card-body-custom">
                                <div class="product-name">Green Apple</div>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star empty"></i>
                                    <i class="bi bi-star empty"></i>
                                </div>
                                <div class="price-row">
                                    <span class="price-main">$14.99</span>
                                     <button href="singleProduct.html"  class="cart-btn"><i class="bi bi-bag"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-4 col-xl-3 product-col snacks">
                        <div class="hotProduct-card">
                            <div class="product-img-wrap">
                                <div class="img-overlay">
                                    <div class="overlay-icons">
                                        <button><i class="bi bi-heart"></i></button>
                                        <button title="Quick View"><i class="bi bi-eye"></i></button>
                                    </div>
                                </div>
                                <img src=" {{ asset('frontend/image/Product Image.png')}}" alt="Green Apple">
                            </div>
                            <div class="card-body-custom">
                                <div class="product-name">Green Apple</div>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star empty"></i>
                                    <i class="bi bi-star empty"></i>
                                </div>
                                <div class="price-row">
                                    <span class="price-main">$14.99</span>
                                     <button href="singleProduct.html"  class="cart-btn"><i class="bi bi-bag"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" product-col beverages">
                            <img src=" {{ asset('frontend/image/nodata.png')}}" alt="" class="w-100">
                    </div>

                    <div class="col-6 col-lg-4 col-xl-3 product-col beauty-health">
                        <div class="hotProduct-card">
                            <div class="product-img-wrap">
                                <div class="img-overlay">
                                    <div class="overlay-icons">
                                        <button><i class="bi bi-heart"></i></button>
                                        <button title="Quick View"><i class="bi bi-eye"></i></button>
                                    </div>
                                </div>
                                <img src=" {{ asset('frontend/image/hotProduct1 (1).png')}}" alt="Green Apple">
                            </div>
                            <div class="card-body-custom">
                                <div class="product-name">Green Apple</div>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star empty"></i>
                                    <i class="bi bi-star empty"></i>
                                </div>
                                <div class="price-row">
                                    <span class="price-main">$14.99</span>
                                     <button href="singleProduct.html"  class="cart-btn"><i class="bi bi-bag"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" product-col bread-bakery">
                            <img src=" {{ asset('frontend/image/nodata.png')}}" alt="" class="w-100">
                    </div>


                    <!-- আরও Fresh Fruit, Snacks, Beverages ইত্যাদি কার্ড এখানে যোগ করো -->
                    <!-- প্রত্যেক কার্ডে class="product-col vegetables" বা "fresh-fruit" বা "snacks" বা "beverages" দিয়ে দিবে -->

                </div>
            </div>
        </div>
    </div>
</div>
    </section>

</main>
 <!-- ends odf shop main part -->

 <!-- footrer part starts -->

<!-- add to cart popup -->
<section>
  <!-- Cart Overlay -->
<div class="cp-overlay" id="cpOverlay"></div>
 
<!-- Cart Drawer -->
<div class="cp-drawer" id="cpDrawer">
 
  <!-- Header -->
  <div class="cp-header">
    <div class="cp-title">
      
      <img src=" {{ asset('frontend/image/Logo.png')}}" alt="">
     
    </div>
    <button class="cp-close" id="cpClose" aria-label="Close cart">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>
 
  <!-- Items -->
  <div class="cp-items" id="cpItems">
 
    <div class="cp-item" data-id="1">
      <div class="cp-item-img"><img src=" {{ asset('frontend/image/hotProduct1 (2).png')}}" alt=""></div>
      <div class="cp-item-info">
        <div class="cp-item-name">Fresh Indian Orange</div>
        <div class="cp-item-meta">1 kg × <strong>$12.00</strong></div>
      </div>
      <button class="cp-remove" onclick="cpRemoveItem(this)" aria-label="Remove">
        <i class="bi bi-x"></i>
      </button>
    </div>
 
    <div class="cp-item" data-id="2">
      <div class="cp-item-img"><img src=" {{ asset('frontend/image/hotProduct1 (1).png')}}" alt=""></div>
      <div class="cp-item-info">
        <div class="cp-item-name">Green Apple</div>
        <div class="cp-item-meta">1 kg × <strong>$14.00</strong></div>
      </div>
      <button class="cp-remove" onclick="cpRemoveItem(this)" aria-label="Remove">
        <i class="bi bi-x"></i>
      </button>
    </div>
 
  </div>
 
  <!-- Empty state (hidden by default) -->
  <div class="cp-empty" id="cpEmpty">
    <i class="bi bi-bag-x"></i>
    <p>Your cart is empty</p>
    <a href="shop.html" class="cp-shop-link">Browse Products →</a>
  </div>
 
  <!-- Footer -->
  <div class="cp-footer" id="cpFooter">
    <div class="cp-subtotal">
      <span class="cp-sub-label"><span id="cpProductCount">2</span> Product</span>
      <span class="cp-sub-price" id="cpTotal">$26.00</span>
    </div>
    <a href="checkout.html" class="cp-checkout-btn">
      <i class="bi bi-bag-check-fill me-1"></i> Checkout
    </a>
    <a href="#" class="cp-cart-link">Go To Cart</a>
  </div>
 
</div>
 
</section>
<!-- end add to cart popup -->

    <!-- eye pop up starts -->
<!-- Quick View Modal — body এর শেষে একবারই রাখো -->
<div class="qv-backdrop" id="qvBackdrop">
  <div class="qv-modal" role="dialog" aria-modal="true">
    <button class="qv-close" id="qvClose" aria-label="Close"><i class="bi bi-x"></i></button>

    <div class="qv-img-side">
      <img id="qvImg" src="" alt="">
    </div>

    <div class="qv-info-side">
      <span class="qv-category" id="qvCat">Vegetables</span>
      <h2 class="qv-title" id="qvTitle"></h2>
      <div class="qv-stars">
        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
        <i class="bi bi-star empty"></i>
      </div>
      <div class="qv-price-row">
        <span class="qv-price-current" id="qvPrice"></span>
        <span class="qv-price-old" id="qvOld"></span>
        <span class="qv-discount" id="qvDiscount" style="display:none"></span>
      </div>
      <p class="qv-desc" id="qvDesc">Fresh, naturally grown product. Packed with nutrients and flavour — perfect for everyday cooking.</p>
      <div class="qv-qty-row">
        <span class="qv-qty-label">Qty</span>
        <div class="qv-qty-ctrl">
          <button class="qv-qty-btn" id="qvMinus"><i class="bi bi-dash"></i></button>
          <input class="qv-qty-val" id="qvQty" type="number" value="1" min="1" max="99">
          <button class="qv-qty-btn" id="qvPlus"><i class="bi bi-plus"></i></button>
        </div>
      </div>
      <div class="qv-btn-row">
        <button class="qv-btn-cart"><i class="bi bi-cart3"></i> Add to Cart</button>
        <button class="qv-btn-buy"><i class="bi bi-lightning-charge-fill"></i> Buy Now</button>
      </div>
    </div>
  </div>
</div>
    <!-- eye pop up ends -->
 
 
<!-- ═══════════════════════════════════════
     MAIN FOOTER
════════════════════════════════════════ -->
<footer class="main-footer">
  <div class="container">
    <div class="row g-4">
 
      <!-- Brand Column -->
      <div class="col-lg-3 col-md-6 anim-fade-up d1">
        <img src=" {{ asset('frontend/image/logoLight.png')}}" alt="">
 
        <p class="footer-desc">
          Morbi cursus porttitor enim lobortis molestie. Duis gravida turpis dui, eget bibendum magna congue nec.
        </p>
 
        <div class="footer-contact d-flex align-items-center flex-wrap">
          <a href="tel:2195550114">01616-239896</a>
          <span class="separator">or</span>
          <a href="mailto:Proxy@gmail.com">Proxy@gmail.com</a>
        </div>
      </div>
 
      <!-- My Account -->
      <div class="col-lg-2 col-md-3 col-6 anim-fade-up d2">
        <h6 class="footer-col-title">My Account</h6>
        <ul class="footer-links">
           <li><a href="userdashboard.html">My Account</a></li>
           <li><a href="userdashboard.html">Order History</a></li>
          <li><a href="#" class="active">Shoping Cart</a></li>
          <li><a href="wishlist.html">Wishlist</a></li>
        </ul>
      </div>
 
      <!-- Helps -->
      <div class="col-lg-2 col-md-3 col-6 anim-fade-up d3">
        <h6 class="footer-col-title">Helps</h6>
        <ul class="footer-links">
            <li><a href="contact.html">Contact</a></li>
           <li><a href="faq.html">FAQS</a></li>
          <li><a href="#">Terms &amp; Condition</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>
 
      <!-- Proxy -->
      <div class="col-lg-2 col-md-3 col-6 anim-fade-up d4">
        <h6 class="footer-col-title">Proxy</h6>
        <ul class="footer-links">
         <li><a href="about.html">About</a></li>
          <li><a href="shop.html">Shop</a></li>
          <li><a href="#">Product</a></li>
          
        </ul>
      </div>
 
      <!-- Categories -->
      <div class="col-lg-3 col-md-3 col-6 anim-fade-up d5">
        <h6 class="footer-col-title">Categories</h6>
        <ul class="footer-links">
          <li><a href="shop.html">Fruit &amp; Vegetables</a></li>
          <li><a href="shop.html">Meat &amp; Fish</a></li>
          <li><a href="shop.html">Bread &amp; Bakery</a></li>
          <li><a href="shop.html">Beauty &amp; Health</a></li>
        </ul>
      </div>
 
    </div><!-- /row -->
  </div><!-- /container -->
 
  <!-- ── Bottom Bar ── -->
  <div class="footer-bottom mt-4">
    <div class="container">
      <div class="row align-items-center anim-fade-in d6">
 
        <div class="col-md-6 mySign">
          <p>BanglaBazar24/7 eCommerce © 2026. All Rights Reserved <span>Powered By <a href="https://github.com/devwithefran99">devwithErfan</a></span></p>
        </div>
 
        
 
      </div>
    </div>
  </div>
 
  </section>
</footer>

    <!-- footer part ends -->

  
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mixitup@3/dist/mixitup.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="navbar-active.js"></script>
<script src="{{ asset ('frontend/js/common.js') }}"></script>
<script src="{{ asset ('frontend/js/shop.js') }}"></script>
</body>
</html>
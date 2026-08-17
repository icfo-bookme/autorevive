<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
    <div class="brand-logo">
        <a href="{{ URL::to('/admin') }}">
            <img src="{{ asset('mazley_assets/img/logo/automax-lg.png') }}" width="100" alt="">
        </a>
    </div>

    @php
        $userRole = env('USER_ROLE');
        $salesmanRole =env('SALESMAN_ROLE');
        $deliveryManRole =env('DELIVERYMAN_ROLE');
        $teamLeaderRole =env('TEAMLEADER_ROLE');
        $itemInsertRole =env('ITEM_INSERT_ROLE');
        $StockPriceEdit =env('STOCK_PRICE_EDIT_ROLE'); /* 15 */
        $maintainerRole =env('MAINTAINER_ROLE'); /* 16 */
        $hopRole =env('HOP_ROLE');
        $accountsRole =env('ACCOUNTS_ROLE');
        $roles_table = App\admin\role\RoleModel::where('soft_delete', 0)
            ->pluck('id')
            ->toArray();
        $roles = App\admin\UserRolesModel::where('user_id', Auth::user()->id)
            ->where('soft_delete', 0)
            ->pluck('role_id')
            ->toArray();

        $pending_drafted_purchases = App\purchase\PurchaseModel::where(['soft_delete' => 0,'is_draft' => 1])
        ->count();

        $pending_abnormal_purchases = App\purchase\PurchaseModel::whereColumn('paid_amount','!=','total_amount')
            ->where('soft_delete',0)
            ->count();

        /*Counting orders*/
        $pending_pending_orders = App\OrderModel::where('soft_delete', 0)
            ->where('is_approve', 0)
            ->where('is_rejected', 0)
            ->where('delivery_type', '!=', 'shop')
            ->count();
        $pending_approved_orders = App\OrderModel::where('soft_delete', 0)
            ->where('is_approve', 1)
            ->where('is_rejected', 0)
            ->where('delivery_type', '!=', 'shop')
            ->where('shipment_assigned', 0)
            ->count();
        $pending_shimpment_orders = App\shipment\ShipmentModel::whereHas('orders', function ($query) {
            $query
                ->where('is_approve', 1)
                ->where('is_rejected', 0)
                ->where('shipment_assigned', 1)
                ->where('is_shipment', 0);
        })
            ->groupBy('order_id')
            ->orderBy('priority', 'ASC')
            ->orderBy('order_id', 'DESC')
            ->get()
            ->count();
        $pending_pickup_orders = App\pickup\PickupModel::whereHas('orders', function ($query) {
            $query
                ->where('is_approve', 1)
                ->where('is_rejected', 0)
                ->where('shipment_assigned', 1)
                ->where('is_shipment', 0);
        })
            ->groupBy('order_id')
            ->count();

        $total = $pending_pending_orders + $pending_approved_orders + $pending_shimpment_orders + $pending_pickup_orders;

    @endphp

    {{-- Correct Code --->
        $role = App\admin\UserRolesModel::where('user_id', 49)->pluck('role_id')->toArray();
        if (in_array(4, $role)) {
            // show content for the sales man
        } else {
            // show all
        } --}}
    <div class="user-details">
        <div class="media align-items-center user-pointer collapsed" data-toggle="collapse" data-target="#user-dropdown">
            <div class="avatar"><img class="mr-3 side-user-img"
                    src="{{ asset('assets/images/avatars/avatar-2.png') }}"
                    alt="user avatar">{{ Auth::user()->first_name }}</div>
            <div class="media-body">
                <h6 class="side-user-name"></h6>
            </div>
        </div>
        <div id="user-dropdown" class="collapse">
            <ul class="user-setting-menu">
                <!-- <li><a href="javaScript:void(0);"><i class="icon-user"></i> My Profile</a></li> -->
                <li><a href="{{ URL('dashboardSettings') }}"><i class="icon-settings"></i> Setting</a>
                </li>
                <li><a onclick="event.preventDefault();
                  document.getElementById('logout-form-sidebar').submit();" href="#"><i class="icon-power"></i>
                        Logout</a>
                </li>
                <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
        </div>
    </div>


    <!-- SALESMAN -->
    @if (in_array($salesmanRole, $roles))
        <ul class="sidebar-menu">
            <li class="sidebar-header">MAIN NAVIGATION</li>
            <li>
                <a href="{{ URL('/admin') }}" class="waves-effect">
                    <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>POS
                        <?php
                        $pending_due_sales = App\sales\SalesModel::where('payment_due', '>', 0)
                            ->where('is_due_paid', '0')
                            ->where('is_cancelled', 0)
                            ->count();
                        $pending_bookings = App\Booking\Booking::where('soft_delete', 0)
                            ->where('status', 1)
                            ->count();
                        $total = $pending_due_sales + $pending_bookings;

                        ?>
                        @if ($total != 0)
                            <span class="badge badge-primary">{{ $total }}</span>
                        @endif
                    </span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('bookingView') }}"><i class="ti-layout-grid3-alt"></i>Booking</a>
                    </li>
                    <li>
                        <a href="{{ url('bookedOrdersView') }}"><span><i class="ti-layout-grid3-alt"></i></span>All
                            Bookings
                            @if ($pending_bookings != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_bookings }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('salesView') }}"><i class="ti-layout-grid3-alt"></i>Sale</a>
                    </li>
                    <li>
                        <a href="{{ url('salesDueView') }}"><span><i class="ti-layout-grid3-alt"></i></span>Due Sales
                            @if ($pending_due_sales != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_due_sales }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('salesCompletedView') }}"><i class="ti-layout-grid3-alt"></i>Completed
                            Sales</a>
                    </li>

                    <li>
                        <a href="{{ url('allSoldItemsView') }}"><i class="ti-layout-grid3-alt"></i>Sold Items List</a>
                    </li>

                    <li>
                        <a href="{{ url('cancelledSalesView') }}"><i class="ti-layout-grid3-alt"></i>Cancelled
                            Sales</a>
                    </li>
                    <li>
                        <a href="{{ url('outsourceView') }}"><i class="ti-layout-grid3-alt"></i>Outsource</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- DELIVERYMAN -->
    @elseif(in_array($deliveryManRole, $roles))
        <ul class="sidebar-menu">
            <li class="sidebar-header">MAIN NAVIGATION</li>
            <li>
                <a href="{{ URL('/admin') }}" class="waves-effect">
                    <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Order
                        @if ($pending_shimpment_orders != 0)
                            <span class="badge badge-primary">{{ $pending_shimpment_orders }}</span>
                        @endif
                    </span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ URL('shipmentOrderView') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Shipment Orders
                            @if ($pending_shimpment_orders != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_shimpment_orders }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- TEAMLEADER -->
    @elseif(in_array($teamLeaderRole, $roles))
        <ul class="sidebar-menu">
            <li class="sidebar-header">MAIN NAVIGATION</li>
            <li>
                <a href="{{ URL('/admin') }}" class="waves-effect">
                    <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Order
                        @if ($pending_approved_orders != 0 || $pending_pickup_orders != 0)
                            @php
                                $total = $pending_approved_orders + $pending_pickup_orders;
                            @endphp
                            <span class="badge badge-primary">{{ $total }}</span>
                        @endif
                    </span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('approvedOrderView') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Approved Orders
                            @if ($pending_approved_orders != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_approved_orders }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('pickupOrderView') }}"><span><i class="ti-layout-grid3-alt"></i></span>Pickup
                            Orders
                            @if ($pending_pickup_orders != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_pickup_orders }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- ITEM-INSERT-ROLE -->
    @elseif(in_array($itemInsertRole, $roles))
        <ul class="sidebar-menu">
            <li class="sidebar-header">MAIN NAVIGATION</li>
            <li>
                <a href="{{ URL('/admin') }}" class="waves-effect">
                    <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            {{-- <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Website Details</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('siteDetails') }}"><i class="ti-layout-grid3-alt"></i>Website Details</a>
                    </li>

                </ul>
            </li> --}}
            <li>
            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Vendor</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('allVendorView') }}"><i class="ti-layout-grid3-alt"></i>All Vendors</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Category</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('allCategoryView') }}"><i class="ti-layout-grid3-alt"></i>All Categories</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Sub-Category</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('allSubCategoryView') }}"><i class="ti-layout-grid3-alt"></i>All
                            Sub-Categories</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Brand</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('allBrandView') }}"><i class="ti-layout-grid3-alt"></i>All Brands</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Company</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('companySetupView') }}"><i class="ti-layout-grid3-alt"></i>Company Setup</a>
                    </li>
                    <li>
                        <a href="{{ url('allCompaniesView') }}"><i class="ti-layout-grid3-alt"></i>All Companies</a>
                    </li>
                    <li>
                        <a href="{{ url('carBrandSetupView') }}"><i class="ti-layout-grid3-alt"></i>Brand Setup</a>
                    </li>
                    <li>
                        <a href="{{ url('allCarBrandsView') }}"><i class="ti-layout-grid3-alt"></i>All Brands</a>
                    </li>
                    <li>
                        <a href="{{ url('carModelSetupView') }}"><i class="ti-layout-grid3-alt"></i>Model Setup</a>
                    </li>
                    <li>
                        <a href="{{ url('allCarModelsView') }}"><i class="ti-layout-grid3-alt"></i>All Models</a>
                    </li>
                    {{-- <li>
                        <a href="{{ url('carEngineSetupView') }}"><i class="ti-layout-grid3-alt"></i>Engine Setup</a>
                    </li>
                    <li>
                        <a href="{{ url('allCarEnginesView') }}"><i class="ti-layout-grid3-alt"></i>Engines View</a>
                    </li> --}}
                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Item</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('itemSetupView') }}"><i class="ti-layout-grid3-alt"></i>Item Setup</a>
                    </li>

                    <li>
                        <a href="{{ url('allItemsView') }}"><i class="ti-layout-grid3-alt"></i>All Items</a>
                    </li>

                    <li>
                        <a href="{{ url('deliveryChargeView') }}"><i class="ti-layout-grid3-alt"></i>Website Delivery
                            Charge</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Purchase</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('purchaseSetupView') }}"><i class="ti-layout-grid3-alt"></i>Purchase Setup</a>
                    </li>

                    <li>
                        <a href="{{ url('allPurchaseView') }}"><i class="ti-layout-grid3-alt"></i>All Purchases</a>
                    </li>

                    <li>
                        <a href="{{ url('allSinglePurchaseView') }}"><i class="ti-layout-grid3-alt"></i>Purchased Items List</a>
                    </li>

                    <li>
                        <a href="{{ url('allDraftedPurchaseView') }}"><span><i class="ti-layout-grid3-alt"></i></span>Drafted Purchases
                            @if ($pending_drafted_purchases != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_drafted_purchases }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('abnormalPurchaseView') }}"><span><i class="ti-layout-grid3-alt"></i></span>Abnormal Purchases
                            @if ($pending_abnormal_purchases != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_abnormal_purchases }}</span>
                            @endif
                        </a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Stock</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('allStockView') }}"><i class="ti-layout-grid3-alt"></i>All Stocks</a>
                    </li>
                    <li>
                        <a href="{{ url('physicalStockCount') }}"><i class="ti-layout-grid3-alt"></i>Physical Count</a>
                    </li>
                   

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Order
                        @if ($total != 0)
                            <span class="badge badge-primary">{{ $total }}</span>
                        @endif
                    </span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('allOngoingOrderView') }}"><i class="ti-layout-grid3-alt"></i>All Ongoing Orders</a>
                    </li>

                    <li>
                        <a href="{{ url('allOrderView') }}"><span><i class="ti-layout-grid3-alt"></i></span>Pending Orders
                            @if ($pending_pending_orders != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_pending_orders }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('approvedOrderView') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Approved Orders
                            @if ($pending_approved_orders != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_approved_orders }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('shipmentOrderView') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Shipment Orders
                            @if ($pending_shimpment_orders != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_shimpment_orders }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('pickupOrderView') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Pickup Orders
                            @if ($pending_pickup_orders != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_pickup_orders }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('cancelOrderView') }}"><i class="ti-layout-grid3-alt"></i>Cancelled Orders</a>
                    </li>

                    <li>
                        <a href="{{ url('completedOrder') }}"><i class="ti-layout-grid3-alt"></i>Completed Orders</a>
                    </li>

                    <li>
                        <a href="{{ url('orderHistoryView') }}"><i class="ti-layout-grid3-alt"></i>All Orders History</a>
                    </li>

                </ul>
            </li>
            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>POS
                        <?php
                        $pending_due_sales = App\sales\SalesModel::where('payment_due', '>', 0)
                            ->where('is_due_paid', '0')
                            ->where('is_cancelled', 0)
                            ->count();
                        $pending_bookings = App\Booking\Booking::where('soft_delete', 0)
                            ->where('status', 1)
                            ->count();
                        $total = $pending_due_sales + $pending_bookings;
                        ?>
                        @if ($total != 0)
                            <span class="badge badge-primary">{{ $total }}</span>
                        @endif
                    </span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('bookingView') }}"><i class="ti-layout-grid3-alt"></i>Booking</a>
                    </li>

                    <li>
                        <a href="{{ url('bookedOrdersView') }}"><span><i class="ti-layout-grid3-alt"></i></span>All
                            Bookings
                            @if ($pending_bookings != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_bookings }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('salesView') }}"><i class="ti-layout-grid3-alt"></i>Sale</a>
                    </li>

                    <li>
                        <a href="{{ url('salesDueView') }}"><span><i class="ti-layout-grid3-alt"></i></span>Due
                            Sales
                            @if ($pending_due_sales != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_due_sales }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('salesCompletedView') }}"><i class="ti-layout-grid3-alt"></i>Completed
                            Sales</a>
                    </li>

                    <li>
                        <a href="{{ url('allSoldItemsView') }}"><i class="ti-layout-grid3-alt"></i>Sold Items List</a>
                    </li>

                    <li>
                        <a href="{{ url('cancelledSalesView') }}"><i class="ti-layout-grid3-alt"></i>Cancelled
                            Sales</a>
                    </li>
                    <li>
                        <a href="{{ url('outsourceView') }}"><i class="ti-layout-grid3-alt"></i>Outsource</a>
                    </li>

                </ul>
            </li>

        </ul>

        </li>
        </ul>
        </li>
        </ul>
    @elseif(in_array($StockPriceEdit, $roles))
        <ul class="sidebar-menu">
            <li class="sidebar-header">MAIN NAVIGATION</li>
            <li>
                <a href="{{ URL('/admin') }}" class="waves-effect">
                    <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Stock</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('allStockView') }}"><i class="ti-layout-grid3-alt"></i>All Stocks</a>
                    </li>
                    <li>
                        <a href="{{ url('physicalStockCount') }}"><i class="ti-layout-grid3-alt"></i>Physical Count</a>
                    </li>

                </ul>
            </li>
        </ul>


    @elseif(in_array($maintainerRole, $roles) || in_array($hopRole, $roles) || in_array($accountsRole,$roles))
        <ul class="sidebar-menu">
            <li class="sidebar-header">MAIN NAVIGATION</li>

            <li>
                <a href="{{ URL('/admin') }}" class="waves-effect">
                    <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Accounts</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('cashStoragePlatformView') }}"><i class="ti-layout-grid3-alt"></i>Ending Balance</a>
                    </li>
                    <li>
                        <a href="{{ url('costInsertView') }}"><i class="ti-layout-grid3-alt"></i>Cost Add</a>
                    </li>
                    <li>
                        <a href="{{ url('fundInsertView') }}"><i class="ti-layout-grid3-alt"></i>Fund Add</a>
                    </li>
                    <li>
                        <a href="{{ url('reinvestmentView') }}"><i class="ti-layout-grid3-alt"></i>Reinvestment</a>
                    </li>
                    <li>
                        <a href="{{ url('expenseReport') }}"><i class="ti-layout-grid3-alt"></i>Expense Report</a>
                    </li>
                    <li>
                        <a href="{{ url('fundReport') }}"><i class="ti-layout-grid3-alt"></i>Fund Report</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Delivery Team</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('teamLeaderView') }}"><i class="ti-layout-grid3-alt"></i>Team Leaders</a>
                    </li>
                    <li>
                        <a href="{{ url('deliveryTeamView') }}"><i class="ti-layout-grid3-alt"></i>Delivery men</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Order
                        @if ($total != 0)
                            <span class="badge badge-primary">{{ $total }}</span>
                        @endif
                    </span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('allOngoingOrderView') }}"><i class="ti-layout-grid3-alt"></i>All Ongoing Orders</a>
                    </li>

                    <li>
                        <a href="{{ url('allOrderView') }}"><span><i class="ti-layout-grid3-alt"></i></span>Pending Orders
                            @if ($pending_pending_orders != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_pending_orders }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('approvedOrderView') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Approved Orders
                            @if ($pending_approved_orders != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_approved_orders }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('shipmentOrderView') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Shipment Orders
                            @if ($pending_shimpment_orders != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_shimpment_orders }}</span>
                            @endif
                        </a>

                    </li>

                    <li>
                        <a href="{{ url('pickupOrderView') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Pickup Orders
                            @if ($pending_pickup_orders != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_pickup_orders }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('cancelOrderView') }}"><i class="ti-layout-grid3-alt"></i>Cancelled Orders</a>
                    </li>

                    <li>
                        <a href="{{ url('completedOrder') }}"><i class="ti-layout-grid3-alt"></i>Completed Orders</a>
                    </li>

                    <li>
                        <a href="{{ url('orderHistoryView') }}"><i class="ti-layout-grid3-alt"></i>All Orders History</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Payment
                        <?php
                        $pending_payments = App\OrderModel::where('is_approve', 1)
                            ->where('is_rejected', 0)
                            ->where('shipment_assigned', 1)
                            ->where('is_shipment', 1)
                            ->where('is_payment', 0)
                            ->where('soft_delete', 0)
                            ->count();
                        ?>
                        @if ($pending_payments != 0)
                            <span class="badge badge-primary">{{ $pending_payments }}</span>
                        @endif
                    </span>
                    <span><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('collectPayment') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Collect Payments
                            @if ($pending_payments != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_payments }}</span>
                            @endif
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ URL('cashWithdraw') }}" class="waves-effect">
                            <i class="ti-layout-grid3-alt"></i>Cash Withdraw
                        </a>
                    </li> --}}
                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Customer
                        <?php
                        $pending_customer_questions = App\contact\ContactModel::where('soft_delete', 0)
                            ->where('is_replied', 0)
                            ->count();
                        $pending_product_requests = App\Product\ProductRequest::where('soft_delete', 0)
                            ->where('is_approved', 0)
                            ->count();
                        $pending_welcome_calls = App\welcomeCall\WelcomeCallModel::where('status', 0)->count();
                        $total = $pending_customer_questions + $pending_product_requests + $pending_welcome_calls;
                        ?>
                        @if ($total != 0)
                            <span class="badge badge-primary">{{ $total }}</span>
                        @endif
                    </span><i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('allCustomers') }}"><i class="ti-layout-grid3-alt"></i>All Customers</a>
                    </li>

                    <li>
                        <a href="{{ url('allCustomerMailView') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Customer Feedbacks
                            @if ($pending_customer_questions != 0)
                                <span
                                    class="badge badge-pill badge-primary">{{ $pending_customer_questions }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('admin/requests') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Requested Products
                            @if ($pending_product_requests != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_product_requests }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('welcomeCallView') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Welcome Calls
                            @if ($pending_welcome_calls != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_welcome_calls }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Highlight</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('highlightsView') }}"><i class="ti-layout-grid3-alt"></i>All Highlights</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>POS
                        <?php
                        $pending_due_sales = App\sales\SalesModel::where('payment_due', '>', 0)
                            ->where('is_due_paid', '0')
                            ->where('is_cancelled', 0)
                            ->count();
                        $pending_bookings = App\Booking\Booking::where('soft_delete', 0)
                            ->where('status', 1)
                            ->count();
                        $total = $pending_due_sales + $pending_bookings;
                        ?>
                        @if ($total != 0)
                            <span class="badge badge-primary">{{ $total }}</span>
                        @endif
                    </span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('bookingView') }}"><i class="ti-layout-grid3-alt"></i>Booking</a>
                    </li>

                    <li>
                        <a href="{{ url('bookedOrdersView') }}"><span><i class="ti-layout-grid3-alt"></i></span>All
                            Bookings
                            @if ($pending_bookings != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_bookings }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('salesView') }}"><i class="ti-layout-grid3-alt"></i>Sale</a>
                    </li>

                    <li>
                        <a href="{{ url('salesDueView') }}"><span><i class="ti-layout-grid3-alt"></i></span>Due
                            Sales
                            @if ($pending_due_sales != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_due_sales }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('salesCompletedView') }}"><i class="ti-layout-grid3-alt"></i>Completed
                            Sales</a>
                    </li>

                    <li>
                        <a href="{{ url('allSoldItemsView') }}"><i class="ti-layout-grid3-alt"></i>Sold Items List</a>
                    </li>

                    <li>
                        <a href="{{ url('cancelledSalesView') }}"><i class="ti-layout-grid3-alt"></i>Cancelled
                            Sales</a>
                    </li>
                    <li>
                        <a href="{{ url('outsourceView') }}"><i class="ti-layout-grid3-alt"></i>Outsource</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Category</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('allCategoryView') }}"><i class="ti-layout-grid3-alt"></i>All
                            Categories</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Sub-Category</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('allSubCategoryView') }}"><i class="ti-layout-grid3-alt"></i>All
                            Sub-Categories</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Brand</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('allBrandView') }}"><i class="ti-layout-grid3-alt"></i>All Brands</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Car </span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('companySetupView') }}"><i class="ti-layout-grid3-alt"></i>Car Company
                            Setup</a>
                    </li>
                    <li>
                        <a href="{{ url('allCompaniesView') }}"><i class="ti-layout-grid3-alt"></i>All Car
                            Companies</a>
                    </li>
                    <li>
                        <a href="{{ url('carBrandSetupView') }}"><i class="ti-layout-grid3-alt"></i>Car Brand
                            Setup</a>
                    </li>
                    <li>
                        <a href="{{ url('allCarBrandsView') }}"><i class="ti-layout-grid3-alt"></i>All Car
                            Brands</a>
                    </li>
                    <li>
                        <a href="{{ url('carModelSetupView') }}"><i class="ti-layout-grid3-alt"></i>Car Model
                            Setup</a>
                    </li>
                    <li>
                        <a href="{{ url('allCarModelsView') }}"><i class="ti-layout-grid3-alt"></i>All Car
                            Models</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Section</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('allSectionView') }}"><i class="ti-layout-grid3-alt"></i>All Sections</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Item</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('itemSetupView') }}"><i class="ti-layout-grid3-alt"></i>Item Setup</a>
                    </li>

                    <li>
                        <a href="{{ url('allItemsView') }}"><i class="ti-layout-grid3-alt"></i>All Items</a>
                    </li>

                    <li>
                        <a href="{{ url('deliveryChargeView') }}"><i class="ti-layout-grid3-alt"></i>Website
                            Delivery Charge</a>
                    </li>

                </ul>
            </li>


            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Vendor</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('allVendorView') }}"><i class="ti-layout-grid3-alt"></i>All Vendors</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Purchase</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('purchaseSetupView') }}"><i class="ti-layout-grid3-alt"></i>Purchase Setup</a>
                    </li>

                    <li>
                        <a href="{{ url('allPurchaseView') }}"><i class="ti-layout-grid3-alt"></i>All Purchases</a>
                    </li>

                    <li>
                        <a href="{{ url('allSinglePurchaseView') }}"><i class="ti-layout-grid3-alt"></i>Purchased Items List</a>
                    </li>

                    <li>
                        <a href="{{ url('allDraftedPurchaseView') }}"><span><i class="ti-layout-grid3-alt"></i></span>Drafted Purchases
                            @if ($pending_drafted_purchases != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_drafted_purchases }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('abnormalPurchaseView') }}"><span><i class="ti-layout-grid3-alt"></i></span>Abnormal Purchases
                            @if ($pending_abnormal_purchases != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_abnormal_purchases }}</span>
                            @endif
                        </a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Stock
                        <?php
                        $pending_requests = App\permissionRequest\PermissionRequest::where('permission', 0)->count();
                        ?>
                        @if ($pending_requests != 0)
                            <span class="badge badge-primary">{{ $pending_requests }}</span>
                        @endif
                    </span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('allStockView') }}"><i class="ti-layout-grid3-alt"></i>All Stocks</a>
                    </li>
                    <li>
                        <a href="{{ url('physicalStockCount') }}"><i class="ti-layout-grid3-alt"></i>Physical Count</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Report</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    {{-- <li>
                        <a href="{{ url('pendingOrderReport') }}"><i class="ti-layout-grid3-alt"></i>Ongoing Orders Report</a>
                    </li> --}}

                    <li>
                        <a href="{{ url('allOrderReport') }}"><i class="ti-layout-grid3-alt"></i>Orders Report</a>
                    </li>

                    {{-- <li>
                        <a href="{{ url('dailyOrderReport') }}"><i class="ti-layout-grid3-alt"></i>All Orders Report</a>
                    </li> --}}

                    <li>
                        <a href="{{ url('dailyDeliveryReport') }}"><i class="ti-layout-grid3-alt"></i>Delivery Report</a>
                    </li>

                    <li>
                        <a href="{{ url('deadlineMissReport') }}"><i class="ti-layout-grid3-alt"></i>Deadline Miss Report</a>
                    </li>

                    <li>
                        <a href="{{ url('deliveryTeamReport') }}"><i class="ti-layout-grid3-alt"></i>Delivery Team Report</a>
                    </li>

                    <li>
                        <a href="{{ url('dailyPurchaseReport') }}"><i class="ti-layout-grid3-alt"></i>Purchase Report</a>
                    </li>

                    <li>
                        <a href="{{ url('dailySalesReport') }}"><i class="ti-layout-grid3-alt"></i>Sales Report</a>
                    </li>

                    <li>
                        <a href="{{ url('profitLossReport') }}"><i class="ti-layout-grid3-alt"></i>Profit Loss Report</a>
                    </li>

                    <li>
                        <a href="{{ url('netProfitLossReport') }}"><i class="ti-layout-grid3-alt"></i>Net Profit Loss Report</a>
                    </li>

                    <li>
                        <a href="{{ url('dueSalesReport') }}"><i class="ti-layout-grid3-alt"></i>Due Sales Report</a>
                    </li>

                    {{-- <li>
                        <a href="{{ url('cashWithdrawalReport') }}"><i class="ti-layout-grid3-alt"></i>Cash Withdrawal Report</a>
                    </li> --}}

                    <li>
                        <a href="{{ url('collectionReport') }}"><i class="ti-layout-grid3-alt"></i>Pending Payment Report</a>
                    </li>

                    <li>
                        <a href="{{ url('collectedPaymentOrders') }}"><i class="ti-layout-grid3-alt"></i>Payment Report</a>
                    </li>

                    <li>
                        <a href="{{ url('websiteVisitorReport') }}"><i class="ti-layout-grid3-alt"></i>Website Visitors Report</a>
                    </li>

                </ul>
            </li>

        </ul>

        </li>
        </ul>
        </li>
        </ul>
    @elseif(in_array($userRole, $roles))
        <ul class="sidebar-menu">
            <li class="sidebar-header">MAIN NAVIGATION</li>
        </ul>


        <!-- SUPERADMIN -->
    @else
        <ul class="sidebar-menu">
            <li class="sidebar-header">MAIN NAVIGATION</li>

            <li>
                <a href="{{ URL('/admin') }}" class="waves-effect">
                    <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Accounts</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('cashStoragePlatformView') }}"><i class="ti-layout-grid3-alt"></i>Ending Balance</a>
                    </li>
                    <li>
                        <a href="{{ url('costInsertView') }}"><i class="ti-layout-grid3-alt"></i>Cost Add</a>
                    </li>
                    <li>
                        <a href="{{ url('fundInsertView') }}"><i class="ti-layout-grid3-alt"></i>Fund Add</a>
                    </li>
                    <li>
                        <a href="{{ url('reinvestmentView') }}"><i class="ti-layout-grid3-alt"></i>Reinvestment</a>
                    </li>
                    <li>
                        <a href="{{ url('expenseReport') }}"><i class="ti-layout-grid3-alt"></i>Expense Report</a>
                    </li>
                    <li>
                        <a href="{{ url('fundReport') }}"><i class="ti-layout-grid3-alt"></i>Fund Report</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Role Module Settings </span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('/admin/adminPanelRegister') }}"><i class="ti-layout-grid3-alt"></i>User
                            Registration</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/rolesView') }}"><i class="ti-layout-grid3-alt"></i>All Roles</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/modulesView') }}"><i class="ti-layout-grid3-alt"></i>All Modules</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/moduleRouteView') }}"><i class="ti-layout-grid3-alt"></i>All Module
                            Routes</a>
                    </li>

                    <li>
                        <a href="{{ url('admin/moduleInsert') }}"><i class="ti-layout-grid3-alt"></i>Module
                            Registration</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/moduleSetupView') }}"><i class="ti-layout-grid3-alt"></i>Module
                            Route
                            Setup</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/roleInsert') }}"><i class="ti-layout-grid3-alt"></i>Role
                            Registration</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/rolesAssign') }}"><i class="ti-layout-grid3-alt"></i>Role Module
                            Assign</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/rolesAssignUser') }}"><i class="ti-layout-grid3-alt"></i>User Role
                            Assign</a>
                    </li>
                </ul>
            </li>

            {{-- <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Module</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{url('admin/moduleInsert')}}"><i class="ti-layout-grid3-alt"></i>Module Registration</a>
                    </li>
                    <li>
                        <a href="{{url('admin/modulesView')}}"><i class="ti-layout-grid3-alt"></i>All Modules</a>
                    </li>
                    <li>
                        <a href="{{url('admin/moduleSetupView')}}"><i class="ti-layout-grid3-alt"></i>Module Route Setup</a>
                    </li>
                    <li>
                        <a href="{{url('admin/moduleRouteView')}}"><i class="ti-layout-grid3-alt"></i>All Module Routes</a>
                    </li>
                </ul>
            </li> --}}

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Delivery Team</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('teamLeaderView') }}"><i class="ti-layout-grid3-alt"></i>Team Leaders</a>
                    </li>
                    <li>
                        <a href="{{ url('deliveryTeamView') }}"><i class="ti-layout-grid3-alt"></i>Delivery men</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Order
                        @if ($total != 0)
                            <span class="badge badge-primary">{{ $total }}</span>
                        @endif
                    </span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('allOngoingOrderView') }}"><i class="ti-layout-grid3-alt"></i>All Ongoing  Orders</a>
                    </li>

                    <li>
                        <a href="{{ url('allOrderView') }}"><span><i class="ti-layout-grid3-alt"></i></span>Pending Orders
                            @if ($pending_pending_orders != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_pending_orders }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('approvedOrderView') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Approved Orders
                            @if ($pending_approved_orders != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_approved_orders }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('shipmentOrderView') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Shipment Orders
                            @if ($pending_shimpment_orders != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_shimpment_orders }}</span>
                            @endif
                        </a>

                    </li>

                    <li>
                        <a href="{{ url('pickupOrderView') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Pickup Orders
                            @if ($pending_pickup_orders != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_pickup_orders }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('cancelOrderView') }}"><i class="ti-layout-grid3-alt"></i>Cancelled Orders</a>
                    </li>

                    <li>
                        <a href="{{ url('completedOrder') }}"><i class="ti-layout-grid3-alt"></i>Completed Orders</a>
                    </li>

                    <li>
                        <a href="{{ url('orderHistoryView') }}"><i class="ti-layout-grid3-alt"></i>All Orders History</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Payment
                        <?php
                        $pending_payments = App\OrderModel::where('is_approve', 1)
                            ->where('is_rejected', 0)
                            ->where('shipment_assigned', 1)
                            ->where('is_shipment', 1)
                            ->where('is_payment', 0)
                            ->where('soft_delete', 0)
                            ->count();
                        ?>
                        @if ($pending_payments != 0)
                            <span class="badge badge-primary">{{ $pending_payments }}</span>
                        @endif
                    </span>
                    <span><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('collectPayment') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Collect Payments
                            @if ($pending_payments != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_payments }}</span>
                            @endif
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ URL('cashWithdraw') }}" class="waves-effect">
                            <i class="ti-layout-grid3-alt"></i>Cash Withdraw
                        </a>
                    </li> --}}
                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Customer
                        <?php
                        $pending_customer_questions = App\contact\ContactModel::where('soft_delete', 0)
                            ->where('is_replied', 0)
                            ->count();
                        $pending_product_requests = App\Product\ProductRequest::where('soft_delete', 0)
                            ->where('is_approved', 0)
                            ->count();
                        $pending_welcome_calls = App\welcomeCall\WelcomeCallModel::where('status', 0)->count();
                        $total = $pending_customer_questions + $pending_product_requests + $pending_welcome_calls;
                        ?>
                        @if ($total != 0)
                            <span class="badge badge-primary">{{ $total }}</span>
                        @endif
                    </span><i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('allCustomers') }}"><i class="ti-layout-grid3-alt"></i>All Customers</a>
                    </li>

                    <li>
                        <a href="{{ url('allCustomerMailView') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Customer Feedbacks
                            @if ($pending_customer_questions != 0)
                                <span
                                    class="badge badge-pill badge-primary">{{ $pending_customer_questions }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('admin/requests') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Requested Products
                            @if ($pending_product_requests != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_product_requests }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('welcomeCallView') }}"><span><i
                                    class="ti-layout-grid3-alt"></i></span>Welcome Calls
                            @if ($pending_welcome_calls != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_welcome_calls }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Highlight</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('highlightsView') }}"><i class="ti-layout-grid3-alt"></i>All Highlights</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>POS
                        <?php
                        $pending_due_sales = App\sales\SalesModel::where('payment_due', '>', 0)
                            ->where('is_due_paid', '0')
                            ->where('is_cancelled', 0)
                            ->count();
                        $pending_bookings = App\Booking\Booking::where('soft_delete', 0)
                            ->where('status', 1)
                            ->count();
                        $total = $pending_due_sales + $pending_bookings;
                        ?>
                        @if ($total != 0)
                            <span class="badge badge-primary">{{ $total }}</span>
                        @endif
                    </span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('bookingView') }}"><i class="ti-layout-grid3-alt"></i>Booking</a>
                    </li>

                    <li>
                        <a href="{{ url('bookedOrdersView') }}"><span><i class="ti-layout-grid3-alt"></i></span>All
                            Bookings
                            @if ($pending_bookings != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_bookings }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('salesView') }}"><i class="ti-layout-grid3-alt"></i>Sale</a>
                    </li>

                    <li>
                        <a href="{{ url('salesDueView') }}"><span><i class="ti-layout-grid3-alt"></i></span>Due
                            Sales
                            @if ($pending_due_sales != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_due_sales }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('salesCompletedView') }}"><i class="ti-layout-grid3-alt"></i>Completed
                            Sales</a>
                    </li>

                    <li>
                        <a href="{{ url('allSoldItemsView') }}"><i class="ti-layout-grid3-alt"></i>Sold Items List</a>
                    </li>

                    <li>
                        <a href="{{ url('cancelledSalesView') }}"><i class="ti-layout-grid3-alt"></i>Cancelled
                            Sales</a>
                    </li>

                    <li>
                        <a href="{{ url('outsourceView') }}"><i class="ti-layout-grid3-alt"></i>Outsource</a>
                    </li>
                    <li>
                        <a href="{{ route('sale_logs.view') }}"><i class="ti-layout-grid3-alt"></i>Sale Logs</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Category</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('allCategoryView') }}"><i class="ti-layout-grid3-alt"></i>All
                            Categories</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Sub-Category</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('allSubCategoryView') }}"><i class="ti-layout-grid3-alt"></i>All
                            Sub-Categories</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Brand</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('allBrandView') }}"><i class="ti-layout-grid3-alt"></i>All Brands</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Car </span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('companySetupView') }}"><i class="ti-layout-grid3-alt"></i>Car Company
                            Setup</a>
                    </li>
                    <li>
                        <a href="{{ url('allCompaniesView') }}"><i class="ti-layout-grid3-alt"></i>All Car
                            Companies</a>
                    </li>
                    <li>
                        <a href="{{ url('carBrandSetupView') }}"><i class="ti-layout-grid3-alt"></i>Car Brand
                            Setup</a>
                    </li>
                    <li>
                        <a href="{{ url('allCarBrandsView') }}"><i class="ti-layout-grid3-alt"></i>All Car
                            Brands</a>
                    </li>
                    <li>
                        <a href="{{ url('carModelSetupView') }}"><i class="ti-layout-grid3-alt"></i>Car Model
                            Setup</a>
                    </li>
                    <li>
                        <a href="{{ url('allCarModelsView') }}"><i class="ti-layout-grid3-alt"></i>All Car
                            Models</a>
                    </li>
                    {{-- <li>
                        <a href="{{ url('carEngineSetupView') }}"><i class="ti-layout-grid3-alt"></i>Engine Setup</a>
                    </li>
                    <li>
                        <a href="{{ url('allCarEnginesView') }}"><i class="ti-layout-grid3-alt"></i>Engines View</a>
                    </li> --}}
                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Section</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ url('allSectionView') }}"><i class="ti-layout-grid3-alt"></i>All Sections</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Item</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('itemSetupView') }}"><i class="ti-layout-grid3-alt"></i>Item Setup</a>
                    </li>

                    <li>
                        <a href="{{ url('allItemsView') }}"><i class="ti-layout-grid3-alt"></i>All Items</a>
                    </li>

                    <li>
                        <a href="{{ url('deliveryChargeView') }}"><i class="ti-layout-grid3-alt"></i>Website
                            Delivery Charge</a>
                    </li>

                </ul>
            </li>


            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Vendor</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('allVendorView') }}"><i class="ti-layout-grid3-alt"></i>All Vendors</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Purchase</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('purchaseSetupView') }}"><i class="ti-layout-grid3-alt"></i>Purchase Setup</a>
                    </li>

                    <li>
                        <a href="{{ url('allPurchaseView') }}"><i class="ti-layout-grid3-alt"></i>All Purchases</a>
                    </li>

                    <li>
                        <a href="{{ url('allSinglePurchaseView') }}"><i class="ti-layout-grid3-alt"></i>Purchased Items List</a>
                    </li>

                    <li>
                        <a href="{{ url('allDraftedPurchaseView') }}"><span><i class="ti-layout-grid3-alt"></i></span>Drafted Purchases
                            @if ($pending_drafted_purchases != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_drafted_purchases }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('abnormalPurchaseView') }}"><span><i class="ti-layout-grid3-alt"></i></span>Abnormal Purchases
                            @if ($pending_abnormal_purchases != 0)
                                <span class="badge badge-pill badge-primary">{{ $pending_abnormal_purchases }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('purchase-logs.view') }}"><i class="ti-layout-grid3-alt"></i>Purchase Logs</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Stock
                        <?php
                        $pending_requests = App\permissionRequest\PermissionRequest::where('permission', 0)->count();
                        ?>
                        @if ($pending_requests != 0)
                            <span class="badge badge-primary">{{ $pending_requests }}</span>
                        @endif
                    </span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    <li>
                        <a href="{{ url('allStockView') }}"><i class="ti-layout-grid3-alt"></i>All Stocks</a>
                    </li>
                    <li>
                        <a href="{{ url('allEditRequests') }}"><span><i class="ti-layout-grid3-alt"></i></span>Edit Requests
                            @if ($pending_requests != 0)
                                <span class="badge badge-primary">{{ $pending_requests }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('physicalStockCount') }}"><i class="ti-layout-grid3-alt"></i>Physical Count</a>
                    </li>
                      <li>
                        <a href="{{ url('stockOutView') }}"><i class="ti-layout-grid3-alt"></i>Stock Out</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javaScript:void(0);" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Report</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">

                    {{-- <li>
                        <a href="{{ url('pendingOrderReport') }}"><i class="ti-layout-grid3-alt"></i>Ongoing Orders Report</a>
                    </li> --}}

                    <li>
                        <a href="{{ url('allOrderReport') }}"><i class="ti-layout-grid3-alt"></i>Orders Report</a>
                    </li>

                    {{-- <li>
                        <a href="{{ url('dailyOrderReport') }}"><i class="ti-layout-grid3-alt"></i>All Orders Report</a>
                    </li> --}}

                    <li>
                        <a href="{{ url('dailyDeliveryReport') }}"><i class="ti-layout-grid3-alt"></i>Delivery Report</a>
                    </li>

                    <li>
                        <a href="{{ url('deadlineMissReport') }}"><i class="ti-layout-grid3-alt"></i>Deadline Miss Report</a>
                    </li>

                    <li>
                        <a href="{{ url('deliveryTeamReport') }}"><i class="ti-layout-grid3-alt"></i>Delivery Team Report</a>
                    </li>

                    <li>
                        <a href="{{ url('dailyPurchaseReport') }}"><i class="ti-layout-grid3-alt"></i>Purchase Report</a>
                    </li>

                    <li>
                        <a href="{{ url('dailySalesReport') }}"><i class="ti-layout-grid3-alt"></i>Sales Report</a>
                    </li>

                    <li>
                        <a href="{{ url('profitLossReport') }}"><i class="ti-layout-grid3-alt"></i>Profit Loss Report</a>
                    </li>

                    <li>
                        <a href="{{ url('netProfitLossReport') }}"><i class="ti-layout-grid3-alt"></i>Net Profit Loss Report</a>
                    </li>

                    <li>
                        <a href="{{ url('dueSalesReport') }}"><i class="ti-layout-grid3-alt"></i>Due Sales Report</a>
                    </li>

                    {{-- <li>
                        <a href="{{ url('cashWithdrawalReport') }}"><i class="ti-layout-grid3-alt"></i>Cash Withdrawal Report</a>
                    </li> --}}

                    <li>
                        <a href="{{ url('collectionReport') }}"><i class="ti-layout-grid3-alt"></i>Pending Payment Report</a>
                    </li>

                    <li>
                        <a href="{{ url('collectedPaymentOrders') }}"><i class="ti-layout-grid3-alt"></i>Payment Report</a>
                    </li>
                    <li>
                        <a href="{{ url('websiteVisitorReport') }}"><i class="ti-layout-grid3-alt"></i>Website Visitors Report</a>
                    </li>

                </ul>
            </li>

        </ul>

        </li>
        </ul>
        </li>
        </ul>

    @endif
</div>

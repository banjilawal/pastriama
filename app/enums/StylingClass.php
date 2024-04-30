<?php

namespace app\enums;

enum StylingClass: string  {
    case NONE ='';
    case CONTAINER = 'class="class="container"';
    case FORM_CONTAINER = 'class="form"';
    case POPUP_FORM_CONTAINER = 'class="popupForm"';
    case FORM_FIELD = 'class="formField"';
    case POPUP_FORM_FIELD = 'class="popupFormField"';
    case SHOPPING_CART = 'class="shoppingCart"';
    case STATIC_LIST = 'class="staticList"';
    case INTERACTIVE_LIST = 'class="interactiveList"';
    case DASHBOARD_LIST = 'class="dashboardList"';
    case DASHBOARD_CONTAINER = 'class="dashboard"';
    case DASHBOARD_MEMBER = 'class="dashboardMember"';
    case ORDER_ITEM_DASHBOARD = 'class="orderItemDashboard"';
    case BEVELED_LINK = 'class="beveledLink"';
    case NAVBAR = 'class="navbar"';
    case DIV_ROW = 'class="divRow"';
}
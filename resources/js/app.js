/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

const { default: Echo } = require('laravel-echo');

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// require('./components/Example');
require('./components/pages/Home')
require('./components/pages/Shop')
require('./components/pages/Contact')
require('./components/pages/Account')
require("./components/pages/Product");
require("./components/pages/ShopbyCat");
require("./components/pages/ShopBySection");
require("./components/pages/WishlistPage");


// import EchoLibrary from "laravel-echo"

// window.Echo = new EchoLibrary({
//     broadcaster: 'pusher',
//     key: 'd0ca855f1967975e3912'
// });

// Echo.private('testChannel')
//     .listen('ShipmentAssigned', (e) => {
//         console.log(e);
//     });


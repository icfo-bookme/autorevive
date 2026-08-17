<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  {{-- <script type="text/javascript" src="{{asset('lib/echo.js')}}"></script> --}}


  <script>
    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;
    var pusher = new Pusher('d0ca855f1967975e3912', {
      authEndpoint :'broadcasting/auth',
      cluster: 'ap2',
      encrypted :true,
      auth:{

        headers : {
          'X-CSRF-Token':'{{csrf_token()}}'
        }
      }
    });

    var channel = pusher.subscribe('private-testChannel');
    channel.bind('my-event', function(data) {
      alert(JSON.stringify(data));
    });


//    window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'd0ca855f1967975e3912',
//     cluster:'ap2',
//     encrypted:true,
//     authEndpoint :'broadcasting/auth',

//        auth:{

//         headers : {
//           'X-CSRF-Token':'{{csrf_token()}}'
//         }
//       }
    

// });

// Echo.private('testChannel')
//     .listen('ShipmentAssigned', (e) => {
//         console.log(e);
//     });


// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'd0ca855f1967975e3912',
//     cluster: 'ap2',
//     authEndpoint: 'broadcasting/auth',
//     encrypted: true,
//     forceTLS: true,
//     auth:{

//         headers : {
//           'X-CSRF-Token':'{{csrf_token()}}',
//           Authorization: 'Bearer d0ca855f1967975e3912'
//         }
//       }

// });

// Echo.private('testChannel')
//     .listen('my-event', (e) => {
//         console.log(e);
      
//     });

 

//  window.Echo = new Echo({
//         broadcaster: 'pusher',
//         key: 'd0ca855f1967975e3912',
//         cluster: 'eu',
//         encrypted: true,
//         authEndpoint: 'broadcasting/auth'
//     });


  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
</body>
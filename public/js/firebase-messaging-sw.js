/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/8.3.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.0/firebase-messaging.js');
   
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    apiKey: "AIzaSyALLAuGSoArXKWBykvAjpEa2puOuAMu4tQ",
    authDomain: "carmart-16ac3.firebaseapp.com",
    projectId: "carmart-16ac3",
    storageBucket: "carmart-16ac3.appspot.com",
    messagingSenderId: "131663415489",
    appId: "1:131663415489:web:e49398955f5eef973cec40",
    measurementId: "G-BH87RKHPN3"
  });
  

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    /* Customize notification here */
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };
  
    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});

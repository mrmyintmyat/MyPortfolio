// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyBFkTEp0EiuIyk6NMwyosPxxYgOKN00LTI",
    authDomain: "game-blog-ea72b.firebaseapp.com",
    projectId: "game-blog-ea72b",
    storageBucket: "game-blog-ea72b.appspot.com",
    messagingSenderId: "901426767863",
    appId: "1:901426767863:web:856382e46f40ec62b9f0f2",
    measurementId: "G-9TDXBNL0YD"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    const title =  payload.data.title;
    const options = {
        body: payload.data.body,
        icon: payload.data.icon,
    };
    self.registration.showNotification(
        title,
        options,
    );
    self.addEventListener('notificationclick', function(event){
        const clickedNotification = event.notification;
        clickedNotification.close();
        event.waitUntil(
            clients.openWindow(payload.data.click_action)
        )
    })
});
